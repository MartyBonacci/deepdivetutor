import {Component, OnInit} from "@angular/core";
import {FileUploader} from "ng2-file-upload";
import {Cookies} from "ng2-cookies";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";

@Component({
	templateUrl: "./templates/image.html"
})

export class ImageComponent implements OnInit {
	public uploader: FileUploader = new FileUploader({
		itemAlias: "profile",
		url: "./api/image/",
		headers: [{name: "X-XSRF-TOKEN", value: Cookies.get("XSRF-TOKEN")}],
		additionalParameters: {}
	});

	protected cloudinaryPublicId : string = null;
	protected cloudinaryPublicIdObservable : Observable<string> = new Observable<string>();

	ngOnInit(): void {
		this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
			let reply = JSON.parse(response);
			this.cloudinaryPublicId = reply.data;
			this.cloudinaryPublicIdObservable = Observable.from(this.cloudinaryPublicId);
		};
	}

	uploadImage(): void {
		this.uploader.uploadAll();
	}

	getCloudinaryId(): void {
		this.cloudinaryPublicIdObservable
			.subscribe(cloudinaryPublicId => this.cloudinaryPublicId = cloudinaryPublicId);
	}

}
