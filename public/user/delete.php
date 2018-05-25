<?php
require_once '../../private/initialize.php';
user_require_login();
$title = 'Delete Content';      

if(!isset($_GET['id'])) {
    redirect_to(url_to('/public/user/index.php'));
}
$id = $_GET['id'];

$content = find_content_by_id($id);

if(is_post_request()) {

    $result = delete_content($id);
    $_SESSION['message'] = "Report with Content Id= " . $id . " Has Been Deleted";
    redirect_to(url_to('/public/user/my_report.php'));
    
}
?>
<?php require(SHARED . '/header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_to('/public/user/my_report.php'); ?>">&laquo; Back to Contents</a>

  <div class="content new">
    <h1>Content Info</h1>
    
    <div class="attributes">
        <dl>
            <dt>Content Id :</dt>
            <dd><?php echo $content['contentId']?></dd>
        </dl>
        
        <dl>
            <dt>User Id :</dt>
            <dd><?php echo $content['p_id']?></dd>
        </dl>
        
        <dl>
            <dt>Incident Type :</dt>
            <dd><?php echo $content['InciType']?></dd>
        </dl>
        <dl>
            <dt>Incident Image :</dt>
            <dd><?php echo '<img height="250" width="250" src="data:imagetmp;base64, '.$content['image']. ' ">'; ?></dd>
        </dl>
        <dl>
            <dt>Latitude :</dt>
            <dd><?php echo $content['lat']?></dd>
        </dl>
        
        <dl>
            <dt>Longitude :</dt>
            <dd><?php echo $content['lon']?></dd>
        </dl>
        
        <dl>
            <dt>Date :</dt>
            <dd><?php echo $content['cDate']?></dd>
        </dl>
            
        </div>  
    
        <form action="<?php url_to('/public/content/delete.php?id=' .
        hsc(uc($content['contentId']))); ?>" method="post">
            
            <div id="operations">
                <input type="submit" name="delete" value="Delete Content"/>
            </div>
            
        </form>
                
    </div>
  </div>


<?php require(SHARED . '/footer.php'); ?>  