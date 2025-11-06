<?php   
  $product_id = $data['prod_id'];
  if ($product_id > 0) {
      // Query for reviews and ratings
      $query = "
          SELECT 
              COUNT(*) AS total_reviews, 
              COUNT(DISTINCT ac_id) AS total_rated_accounts
          FROM tbl_item_reviews
          WHERE prod_id = $product_id
      ";

      $review_result = $conn->query($query); // Use a different variable for the second query result

      if ($review_result && $review_result->num_rows > 0) {
          $review_row = $review_result->fetch_assoc();
          $total_reviews = $review_row['total_reviews'];
          $total_rated_accounts = $review_row['total_rated_accounts'];
          $average_rating = $total_rated_accounts > 0 ? round($total_reviews / $total_rated_accounts, 1) : 0;
      } else {
          echo "No reviews found for this product.<br>";
      }
  }
     
?>