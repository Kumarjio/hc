<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
	            <h1>Career Portal Wizard setup</h1>														
	        </div>
			<?php //echo '<pre>';print_r($arrEmployerWizardDetail);// exit();?>
			<div class="row"> 
				<div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_setup'),true); ?>" class="active-icon">
							<i class="glyphicon glyphicon-globe"></i>
                           	<span>Select Domain</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                        <a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_setup_theme'),true); ?>" >
                        	<i class="glyphicon glyphicon-th"></i>
                           	<span>Select Theme</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                      	<a href="#" >
                       		<i class="glyphicon glyphicon-list"></i>
                           	<span>Career Portal Content</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                       	<a href="<?php echo Router::url(array('controller'=>'employers','action'=>'wizard_theme_option'),true); ?>">
							<i class="glyphicon glyphicon-cog"></i>
                            <span>Career Portal Options</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                   	<div class="dashboard-theme-icon">
                       	<a href="#">
                      		<i class="glyphicon glyphicon-file"></i>
                            <span>Review</span>
                        </a>
                    </div>
                </div>
            </div>
			<div class="row search-content-section" id="search_area" style="display:none;">  
                <div class="col-lg-10">
                    <div class="search-content-wrapper"> 
                        <input type="text" class="search-input" placeholder="Find your perfect domain name" id="c_fname"  value="<?php echo $arrEmployerDetail[0]['Employer']['employer_company_name'];?>" style="color: #000;">
                        <button type="button" class="btn btn-primary btn-md-pad col-md-3 search-input-bt" id="domain_search">Search Domain</button> 
                        <div class="clear"></div>    
                    </div>
                </div>
            </div>
                    
                <p id="response_msg"></p>    
                    <div class="row search-content-section" id="selected">  
                    	
                    </div>		
			
		</div>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function ()
{
 $("#search_area").hide();
	$.ajax({
	type: "GET",
	url: "<?php echo Router::url(array('controller'=>'employers','action'=>'purchased_domain'),true); ?>",
	success: function(body) 
		{ 
			
			//alert(body);
				     
			
					if(body == null || body == '')
					{
						$("#search_area").show();
					}
					else
					{
						
						var test = $.parseJSON(body);
						//var k = test.length-1;
						
						var toAppend = "";
						$("#selected").show();	
						toAppend +="<div class='col-lg-10'><div class='search-content-output'><h4>Your Purchased Domain </h4>";    
						toAppend += "<div class='search-output-cols'><div class='search-output-title' style='width:80%;'>"+test.Employerdomain.domain_name+"</div></div>";
						toAppend +="<div class='clear'></div></div></div>";	
						$("#selected").html(toAppend);	
					}
					
					
				
			
					
		}
	});
	
	
});
$("#domain_search").click( function(event){
	
		$("#selected").show();
		$("#selected").html('');
		var c_fname = $("#c_fname").val();
	$.ajax({
	type: "GET",
	url: "https://api.ote-godaddy.com/api/v1/domains/suggest?query="+c_fname,
	success: function(body) 
		{ 
			
			var i=1;
			var toAppend = "";
			toAppend += "<div class='col-lg-10'><div class='search-content-output'><h4>Selected Domain </h4>";
			$.each( body, function( key, value ) {
				
				
				toAppend += "<div class='search-output-cols'><div class='search-output-title' style='width:80%;'>"+value.domain+"</div>";
				toAppend += "<div class='search-output-buy-now'><button type='button' name='buynow' onclick='buy_domain(\""+value.domain+"\")' class='btn btn-primary buy-now' >Buy Now</button></div></div>";
				
			 
			  i++;
			});
			
			toAppend += "</div></div>";
			$("#selected").append(toAppend);
		}
	});
		//event.preventDefault();
		
	});
	
function buy_domain(ass){
$("#response_msg").html('');
	$.ajax({
	url: "<?php echo Router::url(array('controller'=>'employers','action'=>'purchase'),true); ?>",
	type: "POST",
	dataType: 'json',
	data: 'domain='+ass,
	success: function(body) 
		{ 
			if(typeof body.orderId == 'undefined')
			{
				$("#response_msg").text(body.message);
			}
			else
			{
				$("#response_msg").text("You have Purchased '"+ass+"' domain successfully, Order-Id is "+body.orderId);
				$("#search_area").hide();
				$("#selected").hide();
				$("#domain_search").hide();
				
				
			}
			
		}
	});
}
</script>
