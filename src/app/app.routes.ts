import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {ProfileComponent} from "./components/profile.component";
import {BrowseComponent} from "./components/browse.component";
import {NavbarComponent} from "./components/navbar.component";
import {SessionService} from "./services/session.service";
import {FooterComponent} from "./components/footer.component";

export const allAppComponents = [
	HomeComponent,
	ProfileComponent,
	BrowseComponent,
	NavbarComponent,
	FooterComponent
];

export const routes: Routes = [
	{path: "browse", component: BrowseComponent},
	{path: "profile", component: ProfileComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SessionService];

export const routing = RouterModule.forRoot(routes);