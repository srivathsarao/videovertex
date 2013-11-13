$(function() {
	$(".submit").click(
			function() {
				var name = $("#name").val();
				var email = $("#email").val();
				var comment = $("#comment").val();
				var post_id = $("#video_id").val();
				var dataString = 'name=' + name + '&email=' + email	+ '&comment=' + comment + '&video_id=' + post_id;
				if (name == '' || email == '' || comment == '') {
					//alert('Please Give Valid Details');
				} else {
					$("#flash").show();
					$("#flash").fadeIn(400).html('Loading Comment...');
					$.ajax({
						type : "POST",
						url : "includes/savecomments.php",
						data : dataString,
						cache : false,
						success : function(html) {
							$("ul#update").prepend(html);
							$("ul#update li:last").fadeIn("slow");
							$("#name").val(null);
							$("#email").val(null);
							$("#comment").val(null);
							$("#flash").hide();
						}
					});
				}
				return false;
			});
});