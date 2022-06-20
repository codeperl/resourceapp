## About Resource App.
A code assignment app.

### Deliverables

- Laravel API for admin.
- Vuejs app for admin.
- Laravel Web app for visitor.

#### Features
##### Admin Part:
Manage 3 resource types:
- PDF Download
- HTML Snippet
- Link

Create resource based on resource types:
- Pdf should have title and file upload field.
- Html Snippet should have title, snippet description, and html snippet field.
- Link should have title, url and open in new window field.

Above all will be managed via mock admin panel pointed at /admin.
No credential required.  

##### User Part:
- Listing the Pdf, Html and Link resources.
- Show details
- Clicking on pdf should download it.
- Show html snippet and html snippet description. Button to copy html snippet to clipboard.
- Clickable link which should open a page in the same or new tab.

Above all can be done from /.
No credential required. 

## Technology used
- Laravel 9
- Vuejs 2 (Vuejs applications are inside resources/js/admin directory.)
- postgres 14.3

## Patterns I used
- Using repository and service layer to build a layered architecture.
- Thin Model and Controller.
- Followed SOLID principle.
- Eloquent(and a lot of other Model, except doctrine) followed AR pattern. I always try to avoid that pattern because of multiple reasons:
    1. It breaks Single Responsibility Principle.
    2. It creates thick model with time.
    3. `l3aro/pipeline-query-collection` seems a very good option and can also be used. 
    
##### Admin part
- I used vuejs2. I am much familiar with vee-validate v.3 and as you are also ok with it, I choose that. I can convert it to vuejs3 too.
- Resource update operation will refresh the page. I find it simpler and convenient to avoid the next update issues.
- Without publishing the storage, the pdf file can be accessed.
- Pdf download route is validating the extension. However, this won't protect by checking mime type and I am not so sure how may I check
the mimetype from route. I check the mimetype and file in resource validation.
- Admin listing shows using `ResourceController`. But create and update operations for resources are done via Resource specific controllers.
- CREATE, UPDATE, DETAIL, DELETE mixins are used to manage CRUD also fixed with Contracts/Interfaces. 
- `ResourceContract` is used for all concrete Resource services.
- Deletion warning message added in vuejs2 end.
- Keeping forms as simple as possible and less error prone.
- Overall created a foundation and convention so that an application can grow from MVP to larger.

### Visitor part
- Paginated Listing page will show all the resources.
- From detail page visitor should get required functionality.
- Keeping code as simple as possible.

## How to run
1. Create .env file from .env.example file.
2. Change configuration as needed. i.e. Generate APP_KEY, Change APP_NAME, SET DB_* configs.
3. Run migration with seed.
    `php artisan migrate:fresh seed`
4. Run `npm run dev` or `npm run prod` as needed.
5. Run `php artisan serve` for dev environment.
6. Visit /admin to manage resources.
7. Visit / to check the functionalities for visitors.

Appreciating your reviews and that surely help me to improve further. Thanks in advance!
