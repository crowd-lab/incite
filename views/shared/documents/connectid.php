<!DOCTYPE html>
<html lang="en">
<?php
queue_css_file(array('bootstrap', 'style', 'bootstrap.min'));
$db = get_db();

include(dirname(__FILE__).'/../common/header.php');
?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-md-8">
            </div>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-default">Subscribe</button>
                <button type="button" class="btn btn-default">Guide</button>
            </div>
        </div>
        <div class="container">
            <div class="col-md-6">
                <div style="position: fixed; width: 35%;">
                    <textarea name="transcribe_text" rows="20" id="transcribe_copy" style="width: 100%;"><?php echo $this->transcription; ?></textarea>
                    <div class="wrapper">
                        <div id="document_img" class="viewer"></div>
                    </div>
                    <button type="button" class="btn btn-default" id="show">Document</button>
                    <button type="button" class="btn btn-default" id="hide">Transcription</button>
                </div>
            </div>
            <div class="col-md-6">
      
            <h2>Does this document talk about <a href="" data-toggle="popover" title="Definition" data-content="<?php echo $this->subject_definition; ?>"><?php echo $this->subject; ?></a></h2>
			<form action="post">
				<button type="submit" class="btn btn-default" name="connection" value="true">Yes</button>
				<button type="submit" class="btn btn-default" name="connection" value="false">No</button>
			</form>
            <p>It mentions (<?php echo implode(', ', $this->entities);  ?>) and so do the following three documents.</p>
<?php foreach($this->related_documents as $document): ?>
        <div class="">
            <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">
                 <img src="<?php echo $document->getFile()->getProperty('uri'); ?>" class="thumbnail img-responsive">
            </a>
            <h4 style=""><?php echo metadata($document, array('Dublin Core', 'Title')); ?></h4>
        </div>
<?php endforeach; ?>
                <div id="container">
                    <h3> Discussion </h3>
                    <ul id="comments">
                        <li class="cmmnt">
<!--                            <div class="avatar"><a href="javascript:void(0);"><img src="images/dark-cubes.png" width="55" height="55" alt="DarkCubes photo avatar"></a></div>
-->
                            <div class="cmmnt-content">
                                <header><a href="javascript:void(0);" class="userlink">DarkCubes</a> - <span class="pubdate">posted 1 week ago</span></header>
                                <p>Ut nec interdum libero. Sed felis lorem, venenatis sed malesuada vitae, tempor vel turpis. Mauris in dui velit, vitae mollis risus. Cras lacinia lorem sit amet augue mattis vel cursus enim laoreet. Vestibulum faucibus scelerisque nisi vel sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pellentesque massa ac justo tempor eu pretium massa accumsan. In pharetra mattis mi et ultricies. Nunc vel eleifend augue. Donec venenatis egestas iaculis.</p>
                            </div>
                        </li>
                    </ul>
<?php if (isset($_SESSION['Incite']['IS_LOGIN_VALID']) && $_SESSION['Incite']['IS_LOGIN_VALID'] == true /** && is_permitted **/): ?>
                    <textarea name="transcribe_text" cols="60" rows="10" id="comment">Your comment</textarea>
                    <button type="button" class="btn btn-default" id="">Submit</button>
<?php else: ?>
                    Please login or signup to join the discussion!
                </div>
<?php endif; ?>
    </div>
            </div> 
        </div>




  
</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->

    <!-- Bootstrap Core JavaScript -->
    <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "hover" });
        $("#document_img").hide();
    $("#hide").click(function(){
        $("#document_img").hide();
        $("#transcribe_copy").show();
    });
    $("#show").click(function(){
        $("#document_img").show();
        $("#transcribe_copy").hide();
    });
});
</script>
<script type="text/javascript">
            var $ = jQuery;
            $(document).ready(function(){

                  var iv2 = $("#document_img").iviewer(
                  {
                      src: "<?php echo $this->connection->getFile()->getProperty('uri'); ?>"
                  });

            });
            $('.viewer').height($(window).height()*68/100);
        </script>
<style>
            .viewer
            {
                width: 100%;
                border: 1px solid black;
                position: relative;
            }
            
            .wrapper
            {
                overflow: hidden;
            }
        </style>

</body>

</html>
