jQuery(function($) {

	$('#add_review').submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: '/wp-content/plugins/review-arthur/public/partials/add_review.php',
			data: $(this).serialize(),
			success: () => {
				console.log('Send review');
				$(this).trigger('reset'); // очищаем поля формы
				setTimeout(function(){
					$('.overlay-review').show();
					$('#popup-review-send').show();
				}, 500);
			},
			error: () => {
				console.log('Erorr send review');
				$('#popup-review-send .popup-review__info').html('Error, please try again later!');
				$('.overlay-review').show();
				$('#popup-review-send').show();
			}
		});
	});

	$('#review-submit').click(function(){
		$('#add_review').trigger('reset'); // очищаем поля формы
		$('#popup-review-send .popup-review__info').html('Your review has been sent for moderation!');
		setTimeout(function(){
			$('.overlay-review').show();
			$('#popup-review-send').show();
		}, 500);
	});

	$('.popup-review .popup-review__close, .overlay-review').click(function() {
		$('.overlay-review, .popup-review').hide();
	})
});

