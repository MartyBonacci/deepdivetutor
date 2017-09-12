import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./components/app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {SessionService} from "./services/session.service";
import {CookieService} from "ng2-cookies";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports: [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap: [AppComponent],
	providers: [appRoutingProviders]
})
export class AppModule {
	cookieJar : any = {};

	constructor(protected cookieService: CookieService, protected sessionService: SessionService) {}

	run() : void {
		this.sessionService.setSession()
			.subscribe(response => {
				this.cookieJar = this.cookieService.getAll();
				console.log(this.cookieJar['profileId']);
			});
	}
}