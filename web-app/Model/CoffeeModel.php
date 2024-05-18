<?php

require("Entities/CoffeeEntity.php");

class CoffeeModel {

    // Get all coffee types from the database and return them in an array.
    function GetCoffeeTypes() {
        require 'Credentials.php';

        // Open connection and select database.   
        $conn = mysqli_connect($host, $user, $passwd, $database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $result = mysqli_query($conn, "SELECT DISTINCT type FROM coffee");
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $types = array();

        // Get data from database.
        while ($row = mysqli_fetch_array($result)) {
            array_push($types, $row['type']);
        }

        // Close connection and return result.
        mysqli_close($conn);
        return $types;
    }

    // Get coffeeEntity objects from the database and return them in an array.
    function GetCoffeeByType($type) {
        require 'Credentials.php';

        // Open connection and select database.     
        $conn = mysqli_connect($host, $user, $passwd, $database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $type = mysqli_real_escape_string($conn, $type);
        $query = "SELECT * FROM coffee WHERE type LIKE '$type'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $coffeeArray = array();

        // Get data from database.
        while ($row = mysqli_fetch_array($result)) {
            $name = $row['name'];
            $type = $row['type'];
            $price = $row['price'];
            $roast = $row['roast'];
            $country = $row['country'];
            $image = $row['image'];
            $review = $row['review'];

            // Create coffee objects and store them in an array.
            $coffee = new CoffeeEntity(-1, $name, $type, $price, $roast, $country, $image, $review);
            array_push($coffeeArray, $coffee);
        }

        // Close connection and return result
        mysqli_close($conn);
        return $coffeeArray;
    }

}

?>
