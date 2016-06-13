/**
 * Performs validations on dynamic relations forms, such as avoid seleting the same element more than once, etc
 */
(function($){
	var listContainer = "ul.list-group";
	var listItem = "li.form-group";
	var propertyClass = "dynamic-relation-property";
	var valueClass = "dynamic-relation-value";
	
	$(".add-dynamic-relation").click(function(){   
		
		// The node to be monitored
		var target = $(listContainer)[0];

		// Configuration of the observer:
		var observerConfig = {  
			childList: true,  
		};
		var observer = setObserver(target);
		 
		
		function setObserver(target){
			// Create an observer instance
			var observer = new MutationObserver(function( mutations ) {
			  mutations.forEach(function( mutation ) {
			    var newNodes = mutation.addedNodes; // DOM NodeList
			    if( newNodes !== null ) { // If there are new nodes added
			    	var $nodes = $( newNodes ); // jQuery set
			    	$nodes.each(function() {
			    		var $node = $( this );
			    		if( $node.hasClass( "form-group" ) ) {
			    			console.log("Add dynamic relation");
			    			var uniqid;
			    			uniqid = $(listItem + " select:last").attr("id");
			    			console.log(uniqid);
			    			validateUniqueOptions(uniqid, false); 
			    		}
			    	});
			    }
			  });    
			});
			
			// Pass in the target node, as well as the observer options
			observer.observe(target, observerConfig);
			return observer;
		}
		
		
		function unsetObserver(){
			// Later, you can stop observing
	        observer.disconnect();
		}
		
	    
	    function validateUniqueOptions(selectID, stopPropagate){
	        console.log("Validate select/span id:"+selectID+ ", stopPropagate=" + stopPropagate) 
	        unsetObserver();
	        
	        if ( $("#"+selectID).is("select") ){
	            //get selected elements from other selects and spans
	        	removeAlreadySelectedOptions(selectID);        
	            
	            //remove view when there is no features available
	            removeUnusedView(selectID);
	        }                      
	        
	        removeCurrentSelectedOptionFromOthers(selectID);
	        
	        if (!stopPropagate){
	            var previousOptionValue;
	            var previousOptionText;
	            var previousOptionGroup;
	            //Event handler to validate others when changing this
	            $("#"+selectID).on('focus', function () {
	                // Store the current value on focus and on change
	            	previousOptionValue = $(this).find("option:selected").val();
	            	previousOptionText = $(this).find("option:selected").text();
	            	previousOptionGroup = $(this).find("option:selected").attr("data-optgroup");
	            }).change(function (){
	                console.log("Change made to #" + selectID + " from " + previousOptionText + " to " + $(this).find("option:selected").text() );
	                getOtherSelects(selectID).each(function(){
	                    var other = $(this);
	                    console.log("Other select id:"+other.attr("id"));

	                    if (previousOptionGroup != null){
	                    	var group = other.find("optgroup[label='"+previousOptionGroup+"']");
	                    	// Create the optiongroup if not exists
	                    	if (group.length == 0){
	                    		other.append("<optgroup label='" + previousOptionGroup +"' ></optgroup>");
	                    		group = $("#"+selectID).find("optgroup[label='"+previousOptionGroup+"']");
	                    	}
	                    	group.append("<option value="+previousOptionValue+" data-optgroup="+previousOptionGroup+">"+previousOptionText+"</option>");
		                    console.log("Append option " + previousOptionText + " to select " + selectID + " to group " + previousOptionGroup);
	                    }
	                    else{
	                    	other.append("<option value="+previousOptionValue+">"+previousOptionText+"</option>");
		                    console.log("Append option " + previousOptionText + " to select " + selectID);
	                    }
	                    
	                    validateUniqueOptions(other.attr("id"), true);
	                });
	            });
	            
	            //Event handler to append span values to this select when they are removed
	            getOtherSpans(selectID).each(function(){
	            	var span = $(this);
	            	span.closest(listItem).find(".remove-dynamic-relation").on("click",function(){
		            	console.log("Removing span id:"+span.attr("id"));
		            	
		            	var optionValue = span.next("input[type='hidden']").val();
		            	if (span.hasClass("dynamic-relation-optgroup")){
		            		var optionText = span.siblings("input[type=text]").val();
		            		var optionGroup = span.text();
		            	}
		            	else{
		            		var optionText = span.text();
		            		var optionGroup = null;
		            	}                   
	                    
		            	
	                    if (optionGroup != null){
	                    	var group = $("#"+selectID).find("optgroup[label='"+optionGroup+"']");
	                    	// Create the optiongroup if not exists
	                    	if (group.length == 0){
	                    		$("#"+selectID).append("<optgroup label='" + optionGroup +"' ></optgroup>");
	                    		group = $("#"+selectID).find("optgroup[label='"+optionGroup+"']");
	                    	}
	                    	group.append("<option value="+optionValue+" data-optgroup="+optionGroup+">"+optionText+"</option>");
		                    console.log("Append option " + optionText + " to select " + selectID + " to group " + optionGroup);
	                    }
	                    else{
	                    	$("#"+selectID).append("<option value="+optionValue+">"+optionText+"</option>");
		                    console.log("Append option " + optionText + " to select " + selectID);
	                    }
	            	});
	            });
	            
	            
	            //Event handler to append selected option to others when removing this
	             $("#"+selectID).closest(listItem).find(".remove-dynamic-relation").on("click",function(){
	                 
	                 if ($("#"+selectID).is("select")){
	                    var optionValue = $("#"+selectID +" option:selected").val();
	                    var optionText = $("#"+selectID +" option:selected").text();
	                    var optionGroup = $("#"+selectID +" option:selected").attr("data-optgroup");
	                 }
	                 else{
	                    var optionText = $("#"+selectID).text();
	                    var optionValue = $("#"+selectID).next("input[type='hidden']").val();
	                 }
	                 
	                 console.log("Removing #" + selectID + ". Value=" + optionValue + " Text=" +optionText + " Option group=" + optionGroup);
	                 
	                 getOtherSelects(selectID).each(function(){      
	                    var other = $(this);     
	                    var group = other.find("optgroup[label='"+optionGroup+"']");
	                    if (group.length != 0){
	                    	group.append("<option value="+optionValue+" data-optgroup="+optionGroup+">"+optionText+"</option>");
		                    console.log("Append option " + optionText + " to select " + other.attr("id") + " to group " + optionGroup);
	                    }
	                    else{
	                    	other.append("<option value="+optionValue+">"+optionText+"</option>");
		                    console.log("Append option " + optionText + " to select " + other.attr("id"));
	                    }
	                    
	                });
	            });  
	            
	        }                    
	    }
	    
	    function getOtherSpans(selectID) {
	        return $("#"+selectID).closest(listContainer).find(listItem + "  span." + propertyClass).not("#"+selectID); 
	    }
	    
	    function getOtherSelects(selectID) {
	        return $("#"+selectID).closest(listContainer).find(listItem + "  select").not("#"+selectID); 
	    }
	    
	    function removeCurrentSelectedOptionFromOthers(selectID){
	    	console.log("Begin removeCurrentSelectedOptionFromOthers");
	        getOtherSelects(selectID).each(function(){
        		console.log("Removing "+$("#"+selectID).find("option:selected").text()+ " from " + $(this)[0].id);
	            $("#"+$(this)[0].id +" option[value='"+$("#"+selectID).find("option:selected").val()+"']").remove();
	            
	        });
	        console.log("End removeCurrentSelectedOptionFromOthers");
	    }
	    
	    function removeUnusedView(selectID){
	        if ( $("#"+selectID +" option").size() == 0){
	            alert($("#"+selectID).closest(".form").attr("data-message"));
	            setTimeout(function removeView(){
	                $("#"+selectID).closest(".form").prev(".remove-dynamic-relation").trigger("click");
	            }, 500);                           
	        } 
	    }
	    
	    function removeAlreadySelectedOptions(selectID){
	    	console.log("Begin removeAlreadySelectedOptions");
	        getOtherSelects(selectID).each(function(){
	            console.log("Removing "+$(this).find("option:selected").text()+ " from " + selectID);
	            $("#"+selectID +" option[value='"+$(this).find("option:selected").val()+"']").remove();
	        });
	        getOtherSpans(selectID).each(function(){
	            var optionText = $(this).text();
	            
	            $("#"+selectID +" option").each(function(){
	                if ($(this).text()==optionText){
	                    console.log("Removing "+optionText+ " from " + selectID);
	                    $(this).remove();
	                }
	            });
	        });
	        console.log("End removeAlreadySelectedOptions");
	    }
	});
})(jQuery);