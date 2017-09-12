import { platformBrowserDynamic } from "@angular/platform-browser-dynamic";
import { AppModule } from "./app/app.module";
import { enableProdMode } from "@angular/core";

window.addEventListener("DOMContentLoaded", event => {
	// only use when app is going live; affects debugging
	// enableProdMode();
	platformBrowserDynamic().bootstrapModule(AppModule).then(ref => {
		let app = ref.instance;
		app.run();
	});
});