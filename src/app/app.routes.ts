import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {ProfileComponent} from "./components/profile.component";
import {BrowseComponent} from "./components/browse.component"
import {SessionService} from "./services/session.service";

export const allAppComponents = [HomeComponent, ProfileComponent, BrowseComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "profile", component: ProfileComponent},
	{path: "browse", component: BrowseComponent}
];

export const appRoutingProviders: any[] = [SessionService];

export const routing = RouterModule.forRoot(routes);