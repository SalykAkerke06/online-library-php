document.addEventListener('DOMContentLoaded', function () {
	// Кітаптарды іздеу
	const searchInput = document.getElementById('searchInput')
	const books = document.querySelectorAll('.book')

	if (searchInput) {
		searchInput.addEventListener('input', function () {
			const searchText = searchInput.value.toLowerCase()

			books.forEach(function (book) {
				const bookName = book.textContent.toLowerCase()

				if (bookName.includes(searchText)) {
					book.style.display = 'block'
				} else {
					book.style.display = 'none'
				}
			})
		})
	}
})
