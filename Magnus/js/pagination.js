function getPage(page, limit, method, url, destination) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			destination.innerHTML = xhttp.responseText;
		}
	}
	xhttp.open(method, url, true);
	xhttp.setRequestHeader('HTTP_X_REQUESTED_WITH', 'xmlhttprequest');
	xhttp.send();
}

function pageBtnState(paginator, disabled, direction) {
	switch (direction) {
		case 'forward':
			paginator.find('.page-next').disabled = disabled;
			paginator.find('.page-last').disabled = disabled;
			break;

		case 'backward':
			paginator.find('.page-first').disabled = disabled;
			paginator.find('.page-prev').disabled = disabled;
			break;
	}
}

// Provide a callback with no arguments
function paginator(controls, callback) {
	controls.addEventListener('click', function(e) {
		e.preventDefault();
		action = e.target.classList.value;
		page = controls.find('.paginatorIndex');
		limit = page.dataset.limit;

		switch (action) {
			case 'page-first':
				page.value = 1;
				pageBtnState(controls, true, 'backward');
				pageBtnState(controls, false, 'forward');

				callback();
				break;

			case 'page-prev':
				page.value = page.value - 1;
				pageBtnState(controls, false, 'forward');

				if (page.value < 2) {
					page.value = 1;
					pageBtnState(controls, true, 'backward');
				}

				callback();
				break;

			case 'page-next':
				page.value = page.value + 1;
				pageBtnState(controls, false, 'backward');

				if (page.value > (page.dataset.pages - 1)) {
					page.value = page.dataset.pages;
					pageBtnState(controls, true, 'forward');
				}

				callback();
				break;

			case 'page-last':
				page.value = page.dataset.pages;
				pageBtnState(controls, false, 'backward');
				pageBtnState(controls, true, 'forward');

				callback();
				break;
		}
	});

	controls.addEventListener('change', function(e) {
		e.preventDefault();
		page = controls.find('paginatorIndex');
		
		if (page.value < 2) {
			page.value = 1;
		}

		if (page.value > (page.dataset.pages - 1)) {
			page.value = page.dataset.pages;
		}

		pageBtnState(controls, true, 'backward');
		pageBtnState(controls, true, 'forward');

		if (page.value > 1) {
			pageBtnState(controls, false, 'backward');
		}

		if (page.value < page.dataset.pages) {
			pageBtnState(controls, false, 'forward');
		}
		
		callback();
	});
}