<!DOCTYPE html>
<link rel="stylesheet" href="css/pdfjsViewer.css">
<link rel="stylesheet" href="css/viewerStyle.css">
<script src="js/pdf.js"></script>
<script src="js/pdf.worker.js"></script>

<div role="region" aria-live="polite" aria-label="pdf-Viewer" class="viewer" id="viewer" tabindex="0">
	<div class="loading_box" id="loadingbox">
		<div class="loader"></div>
		<p id="loadingText">Loading...</p>
	</div>

	<div id="canvasdiv" class="canvasdiv" aria-labelledby="pageDesctiption" tabindex="0">
		<canvas id="pdfCanvas"></canvas>
		<div id="textlayer" class="textLayer"></div>
	</div>

	<p id="pageDescription" class="sr-only">Loading pages...</p>

	<div class="NavButtons">
		<div class="pageNav">
			<button id="prev" aria-label="Previous page">&#8592;</button>
			<span class="pageDisplayText">Page: <input type="text" id="page_num"> / <span id="page_count"></span></span>
			<button id="next" aria-label="Next page">&#8594;</button>
		</div>
		<div class="zoomEdit">
			<button id="zoomOut" aria-label="Zoom out">-</button>
			<span class="zoomEditingWindow">&#x1F50E;: <select name="zoom" id="zoom">
					<option value="auto">Automatic</option>
					<option value="0.5">50%</option>
					<option value="0.75">75%</option>
					<option value="1">100%</option>
					<option value="1.25">125%</option>
					<option value="1.50">150%</option>
					<option value="1.75">175%</option>
					<option value="2">200%</option>
				</select></span>
			<button id="zoomIn" aria-label="Zoom in">+</button>
		</div>
	</div>

	<span class="sr-only">Use left and right arrow keys to navigate through the pages.</span>
	<script>
		var pageNum = 1;  // Start with page 1
		var pageRendering = false;
		var pageNumPending = null;
		var scale = 1;
		var pdf = null;
		var url = '<?php echo $_GET['url']; ?>';

		let loadingTask = pdfjsLib.getDocument(url);
		loadingTask.promise.then(function (pdfr) {
			pdf = pdfr;
			renderPage(pageNum, pdf);
			document.getElementById('page_count').textContent = pdf.numPages;

		}).then(function () {
			document.getElementById("loadingbox").style = "display:none;"
		});

		function renderPage(pageNum) {
			pageRendering = true;
			document.getElementById("textlayer").innerHTML = ""
			this.pdf.getPage(pageNum).then(function (page) {

				var scaleSelect = document.getElementById('zoom')
				var container = document.getElementById('canvasdiv');

				if (scaleSelect.value == 'auto') {
					let originalViewport = page.getViewport({ scale: 1.5 });
					this.scale = 1.5;

					var maxWidth = container.offsetWidth - 30;
					const maxHeight = container.offsetHeight - 30;

					if (originalViewport.width > maxWidth) {
						this.scale = Math.min(this.scale, (maxWidth / originalViewport.width) * 1.5);
					}

					if (originalViewport.height > maxHeight) {
						this.scale = Math.min(this.scale, (maxHeight / originalViewport.height) * 1.5);
					}

				} else {
					this.scale = parseFloat(scaleSelect.value);
				}


				let viewport = page.getViewport({ scale: this.scale });

				if (container.offsetHeight > viewport.height) {
					container.classList.add('centerh');
				} else {
					container.classList.remove('centerh');
				}

				if (container.offsetWidth > viewport.width) {
					container.classList.add('centerw');
				} else {
					container.classList.remove('centerw');
				}

				let canvas = document.getElementById('pdfCanvas');
				let context = canvas.getContext('2d');

				canvas.height = viewport.height;
				canvas.width = viewport.width;


				let renderTask = page.render({
					canvasContext: context,
					viewport: viewport
				});

				renderTask.promise.then(function () {
					pageRendering = false;
					if (pageNumPending !== null) {
						renderPage(pageNumPending);
						pageNumPending = null;
					}
				}).then(function () {
					return page.getTextContent();
				}).then(function (textContent) {

					var textLayer = document.querySelector(".textLayer");
					textLayer.style.height = viewport.height + 'px';
					textLayer.style.width = viewport.width + 'px';
					textLayer.style.setProperty('--scale-factor', this.scale);




					// Pass the data to the method for rendering of text over the pdf canvas.
					pdfjsLib.renderTextLayer({
						textContentSource: textContent,
						container: textLayer,
						viewport: viewport,
						textDivs: []
					});
				});
			});
			document.getElementById('page_num').value = pageNum;
			document.getElementById('pageDescription').textContent = "page " + pageNum + " of the pdf.";
			//document.getElementById('canvasdiv').focus();
		}

		/**
		* If another page rendering in progress, waits until the rendering is
		* finised. Otherwise, executes rendering immediately.
		*/
		function queueRenderPage(num) {
			if (pageRendering) {
				pageNumPending = num;
			} else {
				renderPage(num, pdf)
			}
		}
		/**
		 * Displays previous page.
		 */
		function onPrevPage() {
			if (pageNum <= 1) {
				return;
			}
			pageNum--;
			queueRenderPage(pageNum);
		}
		document.getElementById('prev').addEventListener('click', onPrevPage);

		/**
		 * Displays next page.
		 */
		function onNextPage() {
			if (pageNum >= pdf.numPages) {
				return;
			}
			pageNum++;
			queueRenderPage(pageNum);
		}
		document.getElementById('next').addEventListener('click', onNextPage);

		document.getElementById('viewer').addEventListener('keydown', function (event) {
			switch (event.key || event.keyCode) {
				case 'ArrowLeft': // Left arrow
					onPrevPage();
					break;
				case 'ArrowRight': // Right arrow
					onNextPage();
					break;
				default:
					// Ignore other keys
					break;
			}
		});

		document.getElementById('zoomOut').addEventListener('click', function () {
			let zoomSelect = document.getElementById('zoom');
			let currentIndex = zoomSelect.selectedIndex;
			if (currentIndex > 0) {
				zoomSelect.selectedIndex = currentIndex - 1;
			}
			queueRenderPage(pageNum);
		});

		document.getElementById('zoomIn').addEventListener('click', function () {
			let zoomSelect = document.getElementById('zoom');
			let currentIndex = zoomSelect.selectedIndex;
			if (currentIndex < zoomSelect.options.length - 1) {
				zoomSelect.selectedIndex = currentIndex + 1;
			}
			queueRenderPage(pageNum);
		});

		document.getElementById('zoom').addEventListener('change', function () {
			queueRenderPage(pageNum);
		});

		document.getElementById('page_num').addEventListener('keypress', function (e) {
			if (e.key === 'Enter') {
				let inputValue = parseInt(this.value);
				if (isNaN(inputValue) || inputValue < 1 || inputValue >= pdf.numPages) {
					this.value = pageNum;
				} else {
					pageNum = inputValue;
					queueRenderPage(pageNum);
				}
			}
		});

	</script>
</div>