import React from "react";
import ReactDOM from "react-dom";

class App extends React.Component {
	render() {
		return <div>React Component</div>;
	}
}

window.addEventListener("DOMContentLoaded", (event) => {
	if (document.getElementById("react-container"))
		ReactDOM.render(<App />, document.getElementById("react-container"));
});
