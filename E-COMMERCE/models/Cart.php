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

    public static function Create($current_UserID)
    {
        $pdo = self::Connect();
        $stmt = $pdo->prepare("insert into ecommerce.carts (user_id) values (:user_id)");
        $stmt->bindParam(":user_id", $current_UserID);
        if ($stmt->execute()) {
            $stmt = $pdo->prepare("select * from ecommerce.carts where user_id=:user_id");
            $stmt->bindParam("user_id", $current_UserID);
            $stmt->execute();
            $cart = $stmt->fetchObject("Cart");
            return $cart;
        } else {
            throw new PDOException("Errore");
        }
    }

    public function AddProductToCart($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("insert into ecommerce.cart_products (cart_id, product_id, quantita) values (:cart_id, :product_id, :quantita)");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProduct($params)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("update ecommerce.cart_products set quantita = :quantita where cart_id = :cart_id and product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $params['product_id']);
        $stmt->bindParam(':quantita', $params['quantita']);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function removeProduct($product_id)
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("delete from ecommerce.cart_products where cart_id = :cart_id and product_id = :product_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->bindParam(':product_id', $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function FetchAllProducts()
    {
        $pdo = self::Connect();
        $cartId = $this->getId();
        $stmt = $pdo->prepare("select product_id, quantita from ecommerce.cart_products where cart_id = :cart_id");
        $stmt->bindParam(':cart_id', $cartId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPrice()
    {
        $tot = 0;

        foreach ($this->FetchAllProducts() as $pCart) {
            $product = Product::Find($pCart['product_id']);
            $tot += $pCart['quantita'] * $product->getPrezzo();
        }

        return $tot;
    }

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

    public static function FetchAll($current_user)
    {
        $userId = $current_user->getID();
        $pdo = self::Connect();
        $stmt = $pdo->prepare("select * ecommerce.carts where user_id = :id");
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