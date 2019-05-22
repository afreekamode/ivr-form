<?php
$images = array('<div class="thumbnail">
         <a href="images/DSCN0568.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0568.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/DSCN0569.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0569.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/DSCN0572.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0572.JPG"></a>
      </div>
      <div class="clearfix visible-col3"></div>
      <div class="thumbnail">
         <a href="images/DSCN0574.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0574.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/DSCN0575.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0575.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/DSCN0576.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0576.JPG"></a>
      </div>
      <div class="clearfix visible-col3"></div>
      <div class="thumbnail">
         <a href="images/DSCN0581.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0581.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/DSCN0582.JPG" data-rel="PhotoGallery1"><img alt="" src="images/DSCN0582.JPG"></a>
      </div>
      <div class="thumbnail">
         <a href="images/img_02.JPG" data-rel="PhotoGallery1"><img alt="" src="images/img_02.JPG"></a>
      </div>');
function displayImages($images) //to display all images and it dynamic
{
foreach ($images as $value) {
$images = print "<div id='PhotoGallery1'>$value</div>";
}
return $images;
}
?>