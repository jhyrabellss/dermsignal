<?php   
  $product_id = $data['prod_id'];
  if ($product_id > 0) {
      // Query for reviews and ratings
      $query = "
          SELECT 
              COUNT(*) AS total_reviews, 
              AVG(rating) AS average_rating
          FROM tbl_item_reviews
          WHERE prod_id = $product_id
      ";

      $review_result = $conn->query($query);

      if ($review_result && $review_result->num_rows > 0) {
          $review_row = $review_result->fetch_assoc();
          $total_reviews = $review_row['total_reviews'];
          $average_rating = $review_row['average_rating'] > 0 ? round($review_row['average_rating'], 1) : 0;
      } else {
          $total_reviews = 0;
          $average_rating = 0;
      }
  } else {
      $total_reviews = 0;
      $average_rating = 0;
  }
?>