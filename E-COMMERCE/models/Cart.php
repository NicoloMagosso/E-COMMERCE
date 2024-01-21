<?php

class Cart
{
    private $id;
    private $user_id;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    //Metodo per creare un nuovo carrello associato a un utente
    public static function Create($current_UserID)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("INSERT INTO ecommerce.carts (user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $current_UserID);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.carts where user_id=:user_id");
            $stmt->bindParam("user_id", $current_UserID);
            $stmt->execute();
            $cart = $stmt->fetchObject("Cart");
            return $cart;
        } else {
            throw new PDOException("Errore durante la creazione del carrello");
        }
    }

    //Metodo per aggiungere un prodotto al carrello
    public function AddProductToCart($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();

        $stmt = $pdo->prepare("insert into ecommerce.cart_products (cart_id, product_id, quantita) values (:cart_id, :product_id, :quantita)");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);

        return $stmt->execute();
    }

    //Aggiorna la quantità di un prodotto nel carrello
    public function updateProduct($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();

        //Aggiorna la quantità del prodotto nel carrello
        $stmt = $pdo->prepare("update ecommerce.cart_products set quantita = :quantita where cart_id = :cart_id and product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    //Rimuove un prodotto dal carrello
    public function removeProduct($product_id)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();

        $stmt = $pdo->prepare("delete from ecommerce.cart_products where cart_id = :cart_id and product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $product_id);

        return $stmt->execute();
    }

    //Ottiene tutti i prodotti presenti nel carrello
    public function FetchAllProducts()
    {
        $pdo = self::Connect();
        $cartId = $this->getId();

        //Recupera tutti i prodotti nel carrello
        $stmt = $pdo->prepare("select product_id, quantita from ecommerce.cart_products where cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();

        //Restituisce un array associativo con le informazioni sui prodotti nel carrello
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Calcola il totale del carrello in base ai prezzi dei prodotti
    public function getTotalPrice()
    {
        $tot = 0;

        foreach ($this->FetchAllProducts() as $pCart) {
            $product = Product::Find($pCart['product_id']);
            $tot += $pCart['quantita'] * $product->getPrezzo();
        }

        return $tot;
    }

    //Trova il carrello associato a un utente
    public static function Find($user_id)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        if ($stmt->execute()) {
            return $stmt->fetchObject("Cart");
        } else {
            return false;
        }
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }
}

?>