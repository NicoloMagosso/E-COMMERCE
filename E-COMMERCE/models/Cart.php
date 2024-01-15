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

        //Inserisce un nuovo record nel database per il carrello
        $stmt = $pdo->prepare("insert into ecommerce.carts (user_id) values (:user_id)");
        $stmt->bindParam(":user_id", $current_UserID);

        if ($stmt->execute()) {
            //Se l'inserimento è avvenuto con successo, recupera il carrello appena creato
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

        //Inserisce un nuovo record nella tabella dei prodotti nel carrello
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

    //Ottiene tutti i prodotti presenti nel carrello con le relative quantità
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

    //Calcola il totale del carrello in base ai prezzi dei prodotti e alle quantità
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

        return $stmt->execute() ? $stmt->fetchObject("Cart") : false;
    }

    //Ottiene tutti i carrelli associati a un utente
    public static function FetchAll($current_user)
    {
        $userId = $current_user->getID();
        $pdo = self::Connect();

        //Recupera tutti i carrelli associati all'utente
        $stmt = $pdo->prepare("select * from ecommerce.carts where user_id = :id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, "Cart");
    }

    public static function Connect()
    {
        return DbManager::Connect("ecommerce");
    }
}

?>