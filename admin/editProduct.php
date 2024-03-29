<?php
session_start();
include("assets/db/db.php");
$product_id=$_REQUEST['product_id'];

$result=mysqli_query($con,"select * from products where product_id=".$product_id)or die ("query 1 incorrect.......");

list($product_id,$product_type,$brand,$product_name,$price,$details,$pic_name,$tags)=mysqli_fetch_array($result);

if(isset($_POST['btn_save'])) 
{
    $product_name=$_POST['product_name'];
    $details=$_POST['details'];
    $price=$_POST['price'];
    // $c_price=$_POST['c_price'];
    $product_type=$_POST['product_type'];
    $brand=$_POST['brand'];
    $tags=$_POST['tags'];

    if($_FILES['picture']['size'] != 0)
    {
        //picture coding
        $picture_name=$_FILES['picture']['name'];
        $picture_type=$_FILES['picture']['type'];
        $picture_tmp_name=$_FILES['picture']['tmp_name'];
        $picture_size=$_FILES['picture']['size'];

        if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
            {
                if($picture_size<=50000000)
                {
                $pic_name=time()."_".$picture_name;
                move_uploaded_file($_FILES['picture']['tmp_name'],"../product images/".$pic_name);	
                }
                mysqli_query($con,"update products set product_cat=$product_type, product_brand=$brand, product_title='$product_name', product_price=$price, product_desc='$details', product_image='$pic_name', product_keywords='$tags' where product_id='$product_id'")or die("Query 2 is inncorrect..........");
            }
    }
    else
        mysqli_query($con,"update products set product_cat=$product_type, product_brand=$brand, product_title='$product_name', product_price=$price, product_desc='$details', product_keywords='$tags' where product_id='$product_id'")or die("Query 2 is inncorrect..........");
    
    // header("location: productlist.php");
    header("location: sumit_form.php?success=2");
    mysqli_close($con);
}
include "sidenav.php";
include "topheader.php";
?>

     <!-- End Navbar -->
     <div class="content">
        <div class="container-fluid">
          <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
          <div class="row">
          
                
         <div class="col-md-7">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Update Product</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Title</label>
                        <input type="text" id="product_name" required name="product_name" value='<?=$product_name?>' class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="">
                        <label for="">Add Image</label>
                        <input type="file" name="picture"  class="btn btn-fill btn-success" id="picture"  >
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" cols="80" id="details" required name="details" class="form-control" ><?=$details?></textarea>
                      </div>
                    </div>
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pricing</label>
                        <input type="text" id="price" name="price" required class="form-control" value='<?=$price?>'> 
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Categories</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Category</label>
                        <input type="number" id="product_type" name="product_type" required value='<?=$product_type?>' class="form-control">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Product Brand</label>
                        <input type="number" id="brand" name="brand" required class="form-control" value='<?=$brand?>'>
                      </div>
                    </div>
                     
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Keywords</label>
                        <input type="text" id="tags" name="tags" required class="form-control" value='<?=$tags?>' >
                      </div>
                    </div>
                  </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Update Product</button>
              </div>
            </div>
          </div>
          
        </div>
         </form>
          
        </div>
      </div>
      <?php
include "footer.php";
?>