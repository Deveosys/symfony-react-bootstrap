const inputs = Array.from(document.getElementsByClassName("md-form-control"));
inputs.forEach((element: HTMLInputElement) => {
	if (element.value !== "") {
		element.classList.add("filled");
	}
	element.oninput = (e) => {
		if (element.value === "") {
			element.classList.remove("filled");
		} else if (!element.classList.contains("filled")) {
			element.classList.add("filled");
		}
	};
});
