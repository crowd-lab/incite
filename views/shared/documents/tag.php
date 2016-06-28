
  <!DOCTYPE html>
  <html lang="en">
  <?php
  $task = "tag";
  include(dirname(__FILE__).'/../common/header.php');
  ?>

  <style>
  .no-map-marker {
    background-color: #EEEEEE;
  }
  </style>

  <script type="text/javascript">
  var map;
  var msgbox;
  var markers_array = [];
  var nomarkers_array = [];
  var marker_to_id = {};
  var id_to_marker = {};
  function x() {
    $('[data-toggle="popover"]').popover({ trigger: "hover" });
    map = L.map('map-div').setView([37.8, -70], 4);
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var marker;
    <?php
    foreach((array)$this->Tags as $tag) {
      $lat_long = loc_to_lat_long(metadata($tag, array('Item Type Metadata', 'Location')));
      if (count($lat_long) > 0) {
        echo 'marker = L.marker(['.$lat_long['lat'].','.$lat_long['long']."]).addTo(map).bindPopup('".metadata($tag, array('Dublin Core', 'Title'))."');\n";
        echo 'markers_array.push({id:'.$tag->id.', marker: marker});';
        echo 'marker_to_id[marker._leaflet_id]='.$tag->id.';';
        echo 'id_to_marker['.$tag->id.']= marker;';
      } else {
        echo 'nomarkers_array.push({id:'.$tag->id.', marker: marker});';
      }
    }
    ?>
  }

  </script>

  <!-- Page Content -->
  <div id="task_description" style="text-align: center;">
    <h2 style="text-align: center;">Search Results of Taggable Documents</h2>
    <span style="text-align: center;">You can mouse over the pins on the map or document thumbnails to see more details and click them to try tagging the document!
    </span>
  </div>
  <div id="map-div" style="width:500px;"></div>
  <div id="list-view" style="position: absolute; top: 80px; right: 0; left: 100px; width: 30%; height: 500px; background-color: white;">
    <div id="list-view-switch" style="cursor: pointer; border:1px solid; float: left;">Show</div>
    <span style="width: 20px; background: #EEEEEE; margin-right: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span>: Location unknown.</span>
    <br>
    <?php foreach ((array)$this->Tags as $tag): ?>
      <div id="list_id<?php echo $tag->id;?>" style="margin: 10px;" data-toggle="popover"
        data-trigger="hover" data-html="true"
        data-title="<?php echo "<strong>" . metadata($tag, array('Dublin Core', 'Title')) . "</strong>";?>"
        data-placement="left" data-id="<?php echo $tag->id; ?>">
        <?php if (isset($this->query_str) && $this->query !== ""): ?>
          <a href="<?php echo getFullInciteUrl().'/documents/tag/'.$tag->id."?".$this->query_str; ?>">
          <?php else: ?>
            <a href="<?php echo getFullInciteUrl().'/documents/tag/'.$tag->id; ?>">
            <?php endif; ?>
            <div style="height: 40px; width:40px; float: left;">
              <img src="<?php echo $tag->getFile()->getProperty('uri'); ?>" class="thumbnail img-responsive" style="width: 40px; height: 40px;">
            </div>
            <div style="height: 40px; margin-left: 45px;">
              <p style=""><?php echo metadata($tag, array('Dublin Core', 'Title')); ?></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
      <div id="pagination-bar" class="text-center">
        <nav>
          <ul class="pagination">
            <li class="<?php echo ($this->current_page == 1 ? "disabled" : ""); ?>"><a <?php echo ($this->current_page == 1 ? "" : 'href="?page='.($this->current_page-1)); ?><?php echo ($this->query_str == "" ? "" : "&".$this->query_str); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            <?php for ($i = 0; $i < $this->total_pages; $i++): ?>
              <li class="<?php if ($this->current_page == ($i+1)) echo 'active'; ?>"><a href="?page=<?php echo ($i+1); ?><?php echo ($this->query_str == "" ? "" : "&".$this->query_str); ?>"><?php echo ($i+1); ?><span class="sr-only">(current)</span></a></li>
              <?php endfor; ?>
              <li class="<?php echo ($this->total_pages == $this->current_page ? "disabled" : ""); ?>"><a <?php echo ($this->current_page == $this->total_pages ? "" : 'href="?page='.($this->current_page+1)); ?><?php echo ($this->query_str == "" ? "" : "&".$this->query_str); ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
            </ul>
          </nav>
        </div>
      </div>
      <div id="timeline"></div>
      <div id="timeline-spacing" class="col-md-8" style="height:100px;"></div>


    </div>
    <script type="text/javascript">
    var ev = [
      <?php for ($i = 0; $i < count($this->Tags); $i++): ?>
      {
        id : <?php echo $i; ?>,
        name : "<?php echo metadata($this->Tags[$i], array('Dublin Core', 'Title')); ?>",
        desc : "<?php echo metadata($this->Tags[$i], array('Dublin Core', 'Description')); ?>",
        on : new Date("<?php echo metadata($this->Tags[$i], array('Dublin Core', 'Date')); ?>")
      },
      <?php endfor; ?>
    ];
    function showListView() {
      $('#list-view').animate({ left: $(window).width()-$('#list-view').width() }, 'slow', function() {
        $('#list-view-switch').html('Hide');
      });
      $('#list-view-switch').one("click", hideListView);
    }

    function hideListView() {
      $('#list-view').animate({ left: $(window).width()-$('#list-view-switch').width()-5 }, 'slow', function() {
        $('#list-view-switch').html('Show');
      });
      $('#list-view-switch').one("click", showListView);
    }

    function buildTimeLine(evt) {
      $('#timeline').empty();
      tl = $('#timeline').jqtimeline({
        events : evt,
        numYears: (1880-1845),
        startYear: 1845,
        endYear: 1880,
        totalWidth: $('#timeline').width(),
        click:function(e,event){
          alert(event.desc);
        }});
      }

      $('#map-div').ready( function (e) {
        $('#map-div').height($(window).height()-200);
      });

      $(document).ready( function (e) {
        $('#map-div').width($(window).width());
        $('#timeline').width($(window).width()-30);
        document.getElementById('list-view').style.top = ($('#map-div').offset().top+20)+'px';
        document.getElementById('list-view').style.left = ($(window).width()-$('#list-view-switch').width()-5)+'px';
        document.getElementById('list-view').style.height = ($('#map-div').height()-40)+'px';
        showListView();
        buildTimeLine(ev);
        $(window).on('resize', function(e) {
          $('#map-div').width($(window).width());
          $('#timeline').width($(window).width()-30);
          $('#map-div').height($(window).height()-200);
          document.getElementById('list-view').style.left = ($(window).width()-$('#list-view-switch').width()-5)+'px';
          document.getElementById('list-view').style.height = ($('#map-div').height()-40)+'px';
          showListView();
          buildTimeLine(ev);
          //$('#list-view').width($(window).width()*0.15);
        });
        $('#list-view-switch').one('click', showListView);

        x();
        $.each(nomarkers_array, function (idx) {
          $('#list_id'+this['id']).addClass('no-map-marker');
        });
        $.each(markers_array, function (idx) {
          this['marker'].on('mouseover', function (e) {
            $('div[data-id='+marker_to_id[this._leaflet_id]+']').popover('show');
            this.openPopup();
          });
          this['marker'].on('mouseout', function (e) {
            $('div[data-id='+marker_to_id[this._leaflet_id]+']').popover('hide');
            this.closePopup();
          });
          this['marker'].on('click', function (e) {
            this.openPopup();
            window.location.href="/m4j/incite/documents/tag/"+marker_to_id[this._leaflet_id];
          });
        });
        $('[data-toggle="popover"]').each( function (idx) {
          $(this).on('shown.bs.popover', function (e) {
            if (id_to_marker[this.dataset.id])
            id_to_marker[this.dataset.id].openPopup();
          });
          $(this).on('hidden.bs.popover', function (e) {
            if (id_to_marker[this.dataset.id])
            id_to_marker[this.dataset.id].closePopup();
          });
        });
        <?php
        if (isset($_SESSION['incite']['message'])) {

          if (strpos($_SESSION["incite"]["message"], 'Unfortunately') !== false) {
            echo "notifyOfRedirect('" . $_SESSION["incite"]["message"] . "');";
          } else {
            echo "notifyOfSuccessfulActionNoTimeout('" . $_SESSION["incite"]["message"] . "');";
          }

          unset($_SESSION['incite']['message']);
        }
        ?>
        buildPopoverContent();
      });

      function buildPopoverContent() {
        <?php foreach ((array)$this->Tags as $tag): ?>
        var content = '';
        var date = <?php echo sanitizeStringInput(metadata($tag, array('Dublin Core', 'Date'))); ?>.value;
        var location = <?php echo sanitizeStringInput(metadata($tag, array('Item Type Metadata', 'Location'))); ?>.value;
        var source = <?php echo sanitizeStringInput(metadata($tag, array('Dublin Core', 'Source'))); ?>.value;
        var contributor = <?php echo sanitizeStringInput(metadata($tag, array('Dublin Core', 'Contributor'))); ?>.value;
        var rights = <?php echo sanitizeStringInput(metadata($tag, array('Dublin Core', 'Rights'))); ?>.value;

        if (date) {
          content += '<strong>Date: </strong>' + date + '<br><br>';
        }

        if (location) {
          content += '<strong>Location: </strong>' + location + '<br><br>';
        }

        if (source) {
          content += '<strong>Source: </strong>' + source + '<br><br>';
        }

        if (contributor) {
          content += '<strong>Contributor: </strong>' + contributor + '<br><br>';
        }

        if (rights) {
          content += '<strong>Rights: </strong>' + rights + '<br><br>';
        } else {
          content += '<strong>Rights: </strong>Public Domain<br><br>';
        }


        if (content) {
          //cut off the last <br><br>
          content = content.slice(0, -8);

          $('#list_id<?php echo $tag->id; ?>').attr('data-content', content);
        } else {
          $('#list_id<?php echo $tag->id; ?>').attr('data-content', "No available document information, sorry!");
        }
        <?php endforeach; ?>
      }
      </script>


    </div>
    <!-- /.container -->

  </body>


  </html>
