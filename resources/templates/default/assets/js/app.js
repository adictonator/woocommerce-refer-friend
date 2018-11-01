jQuery(function($) {
	$('button[data-raf-prod-id]').on('click', function(e) {
		const prodID = $(this).data('raf-prod-id')
		const formData = $(this)
			.parents('form')
			.serialize()

		const data = {
			action: 'listenAJAX',
			formData: formData
		}

		doFetch('POST', data)
		e.preventDefault()
	})

	$('button[data-raf-refer-send]').on('click', function(e) {
		const formData = $(this)
			.parents('form')
			.serialize()

		const data = {
			action: 'listenAJAX',
			formData: formData
		}

		doFetch('POST', data)
		e.preventDefault()
	})

	/**
	 * Copy to clipboard
	 */
	$('[data-raf-copy-link]').on('click', function() {
		const range = document.createRange()
		range.selectNode(document.querySelector('.link-text'))
		window.getSelection().addRange(range)
		document.execCommand('copy')
		$('.raf-tooltip').addClass('raf-tooltip--visible')
		setTimeout(function() {
			$('.raf-tooltip').removeClass('raf-tooltip--visible')
		}, 900)
	})
})

async function doFetch(method, data) {
	data = Object.entries(data)
		.map(e => e.join('='))
		.join('&')

	await fetch(adminAJAX, {
		method: method,
		credentials: 'same-origin',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded'
		},
		body: data
	})
		.then(x => x.json())
		.then(r => handleResponse(r))
	// .catch(err => alert('Woah! Look what you did! -> ' + err))
}

function handleResponse(response) {
	if (response.type == 'success') {
		jQuery('div[data-raf-popup="refer-prod"]').show()
	} else {
		alert(response.msg)
	}
}
