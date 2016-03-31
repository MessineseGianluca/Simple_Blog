<!DOCTYPE html>
<html lang='en'>
<head>
  <title> Dashboard </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" 
        href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/mycss.css">  
</head>
<body>
  <div class='row post-box' id=' . $post_id . '>
    <div class='col-lg-5 col-xs-12'>
      <div class='panel'>
      <div class='panel-heading'>
		<div class='row'>
		  <div class='col-lg-1 col-xs-2 img-container'>
			<img class='img-rounded user-img' src='img/" . $img_name . "' >
		  </div>
		  <div class='col-lg-11 col-xs-10'>
	        <strong class='author'>" . $surname . " " . $name . "</strong><br> 
		    <span class='text-muted'>commented on</span>
          </div>
        </div>
	  </div>
	  <div class='panel-body text'>
  		<h3 class='text'>" . $description . "</h3>
	  </div><!-- /panel-body -->
	  <div class='panel-footer'>
        <button class='like'>
          <span class='glyphicon glyphicon-heart-empty'></span>
        </button>
        <button class='comm'>
          <span class='glyphicon glyphicon-comment'></span>
        </button>
        <button class='reblog pull-right'>
          <span class='glyphicon glyphicon-plus'></span>
        </button>
      </div>
    </div><!-- /panel -->
	</div><!-- /col-lg-5 col-xs-12 -->
  </div><!-- /row -->
  <!--INCLUSIONS -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src=
    'bower_components/jakobmattsson-jquery-elastic/jquery.elastic.source.js'>
  </script>
  <script src="js/myjs.js"></script>
</body>
</html> 

