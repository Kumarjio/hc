<?php
	
	//print('<pre>');
	//print_r($_SERVER);
	$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$actual_link = urlencode($actual_link);
?>
<div class="examples" style="margin-bottom:0px;text-align:center;width:100%;">
			<!--<span class="button-addon">
				<a href="https://github.com/selz/shr" target="_blank" class="button button-github" data-shr-network="github">
					<svg><use xlink:href="#shr-github"></use></svg>Star
				</a>
			</span>-->
			<span class="button-addon">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $actual_link; ?>" target="_blank" class="button button-facebook" data-shr-network="facebook">
					<svg><use xlink:href="#shr-facebook"></use></svg>Share
				</a>
			</span>
			<a href="https://twitter.com/intent/tweet?text=Simple+sharing+buttons+for+social+networks.&amp;url=<?php echo $actual_link; ?>&amp;via=sam_potts" target="_blank" class="button button-twitter" data-shr-network="twitter">
				<svg><use xlink:href="#shr-twitter"></use></svg>Tweet
			</a>
			<span class="button-addon">
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo $actual_link; ?>&amp;media=http%3A%2F%2Fplacehold.it%2F500x500&amp;description=Simple+sharing+buttons+for+social+networks." target="_blank" class="button button-pinterest" data-shr-network="pinterest">
					<svg><use xlink:href="#shr-pinterest"></use></svg>Pin it
				</a>
			</span>
			<a href="https://plus.google.com/share?url=<?php echo $actual_link; ?>" target="_blank" class="button button-google" data-shr-network="google">
				<svg><use xlink:href="#shr-google"></use></svg>
			</a>
		</div>
		
			 <!-- Load SVG defs -->
        <!-- You should bundle all SVG/Icons into one file using a build tool such as gulp and svg store -->
        <script>
        (function(d, u){
            var x = new XMLHttpRequest(),
                b = d.body;

            // Check for CORS support
            // If you're loading from same domain, you can remove the if statement
            // XHR for Chrome/Firefox/Opera/Safari
            if ("withCredentials" in x) {
                x.open("GET", u, true);
            }
            // XDomainRequest for older IE
            else if(typeof XDomainRequest != "undefined") {
                x = new XDomainRequest();
                x.open("GET", u);
            }
            else {
                return;
            }

            x.send();
            x.onload = function(){
                var c = d.createElement("div");
                c.setAttribute("hidden", "");
                c.innerHTML = x.responseText;
                b.insertBefore(c, b.childNodes[0]);
            }
        })(document, "https://cdn.shr.one/0.1.9/sprite.svg");
        </script>

        <!-- Shr core script -->
        <script src="https://cdn.shr.one/0.1.9/shr.js"></script>

        <!-- Docs script -->
        <script src="https://cdn.shr.one/0.1.9/docs.js"></script>