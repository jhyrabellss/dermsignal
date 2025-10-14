<link rel="stylesheet" href="../styles/slideshow.css">



<div class="slideshow-div">

<div class="slideshow-container">

    <div class="mySlides fade">
      <img src="../images/banner/banner-1.png" style="width:100%">    
    </div>
    <div class="mySlides fade">
      <img src="../images/banner/banner-2.png" style="width:100%">  
    </div>
    <div class="mySlides fade">
      <img src="../images/banner/banner-3.png" style="width:100%">
    </div>


    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  <br>
  
  <!-- The dots/circles -->
  <div class="dots" style="text-align:center"  >
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    
  </div>
</div>  

<script src="../scripts/slideshow.js"></script>