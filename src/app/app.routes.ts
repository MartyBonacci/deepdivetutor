import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {PoliticianComponent} from "./components/user.component";
import {SessionService} from "./services/session.service";


export const allAppComponents = [HomeComponent, UserComponent];

export const routes: Routes = [
	{path: "user", component: UserComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [SessionService];

export const routing = RouterModule.forRoot(routes);