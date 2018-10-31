jQuery(function($) {
	$('button[data-raf-disc="add"]').on('click', function() {
		const discWrap = $('ul[data-raf-disc-wrap]')
		const mainElm = $('li[data-raf-disc-init]')
		const cloneElm = mainElm.clone()

		cloneElm
			.removeAttr('data-raf-disc-init')
			.find('button[data-raf-disc]')
			.attr('data-raf-disc', 'remove')

		cloneElm
			.find('button[data-raf-disc]')
			.removeClass('button-primary')
			.addClass('button-secondary')
			.html('Remove -')

		cloneElm
			.find('input')
			.val('')
			.prop('checked', false)

		// cloneElm.find('select[name^="freeProd"]').attr(
		// 	'name',
		// 	cloneElm
		// 		.find('select[name^="freeProd"]')
		// 		.attr('name')
		// 		.replace('1', '2')
		// )

		cloneElm
			.find('div[data-raf-amount-disc]')
			.show()
			.siblings('div[data-raf-prod-disc]')
			.hide()

		discWrap.append(cloneElm)
	})

	$(document).on('click', 'button[data-raf-disc="remove"]', function() {
		$(this)
			.parents('li')
			.remove()
	})

	$(document).on('click', 'input[data-raf-disc-switch]', function() {
		if ($(this).is(':checked')) {
			$(this).val('yes')
			$(this)
				.parents('li')
				.find('div[data-raf-prod-disc]')
				.show()
				.siblings('div[data-raf-amount-disc]')
				.hide()
		} else {
			$(this).val('no')
			$(this)
				.parents('li')
				.find('div[data-raf-amount-disc]')
				.show()
				.siblings('div[data-raf-prod-disc]')
				.hide()
		}
	})
})
