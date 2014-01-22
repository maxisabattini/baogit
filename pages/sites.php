<?php
$this->app->render("header");
?>
      <h4>Site Listing</h4>
      <hr>      
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Site</th>                
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($sites as $entry):
            ?>
            <tr>                
                <td>
                    <a href="<?=$entry->folder?>"><?=$entry->folder?></a>
                    <!-- Button trigger modal -->
		    <button class="btn btn-primary pull-right options" data-toggle="modal" data-target="#myModal" rel="<?=$entry->folder?>">
		      <span class="glyphicon glyphicon-cog"></span>
		    </button>
                </td>                
		  
		  <!--
		  <div class="btn-group">
		    <button type="button" class="btn btn-default">
		      <span class="glyphicon glyphicon-refresh"></span>
		    </button>		    

		    <div class="btn-group">
		      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">			
			master
			<span class="caret"></span>
		      </button>
		      <ul class="dropdown-menu">
			<li><a href="#">Dropdown link</a></li>
			<li><a href="#">Dropdown link</a></li>
		      </ul>
		    </div>
		  </div>

                  <span class="label label-default pull-right">Clean</span>
                  -->                                 
            </tr>
                        
            <?php
            endforeach;
            ?>

            </tbody>
        </table>      
      

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Site information <span></span></h4>
	      </div>
	      <div class="modal-body">
	      
		<div class="center-block" id="loading-indicator" style="display:none">
		  <img src="images/loading.gif"/>
		</div>
		
		
		<form class="form-horizontal" role="form">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Url</label>
		    <div class="col-sm-10">
		      <p class="form-control-static modal-field" rel="url"></p>
		    </div>
		  </div>

		  <div class="form-group">

		    <label class="col-sm-2 control-label">Branch</label>

		    <div class="col-sm-10">
			<p class="form-control-static modal-field" rel="branch"></p>
		    </div>

		  </div>

		  <div class="form-group">

		    <label class="col-sm-2 control-label">Operations</label>

		    <div class="col-sm-10">		      
		      
				<div class="btn btn-default btn-sm " title="Pull">
					<span class="glyphicon glyphicon-circle-arrow-down">Pull</span>
				</div>

				<div class="btn btn-default btn-sm " title="Stage">
					<span class="glyphicon glyphicon-trash">Stage</span>
				</div>


		        <select rel="branches" class="btn btn-default btn-sm ">
		            <option value=''>N/A</option>
		        </select>
		    </div>

		  </div>
		  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">Status</label>
		    <div class="col-sm-10">
		      <span class="label modal-field" rel="status"></span>
		      <div class="clearfix">&nbsp;</div>

		      <pre rel="status_details" style="height:200px; overflow-y: auto;display:none;"></pre>		      
		      
		    </div>
		  </div>
		  
		</form>
		
	      </div>
	      <div class="modal-footer">
		<div class="console">

		</div>

		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<!--
		<button type="button" class="btn btn-primary">Save changes</button>
		-->
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
      
<?php
use \baobab\JSQueue;
$jsQueue = JSQueue::getInstance();

$jsQueue->beginCode();
?>
<script>

jQuery(document).ready(function(){
    
	function showLoading(){
	  $(".form-horizontal").hide();
	  $('#loading-indicator').show();	  
	}

	function hideLoading(){	  
	  $('#loading-indicator').hide();
	  $(".form-horizontal").show();
	}
	
	$(".options").on("click",function(){	

		showLoading();
		var site=$(this).attr("rel");	  
		$.ajax({
		url: "index2.php/git-info?site="+site,
			context: document.body
		}).done(function(data) {	
		      
			$("#myModalLabel span").html(site);

			$(".modal-field").each(function(){
				var name = $(this).attr("rel");
				$(this).html( data[name] );
			});

			$("[rel=branches]").html('');
			for(var i in data.branches) {                
				$("[rel=branches]").append( $('<option>', { value : data.branches[i] }).text( data.branches[i] ) ); 
			}

			if(data.status != "clean") {
				$("[rel=status]").removeClass("label-success").addClass("label-danger");		
				$("[rel=status_details]").html(data.status_details);
				$("[rel=status_details]").show();
			} else { 
				$("[rel=status]").removeClass("label-danger").addClass("label-success");
				$("[rel=status_details]").html();
				$("[rel=status_details]").hide();
			}      

			hideLoading();
		});	
	});		
    
});

</script>
<?php
$jsQueue->endCode();

$this->app->render("footer"); 

