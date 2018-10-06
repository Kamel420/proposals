

## About Proposals

Proposal is an RESTfull APIs  serves sales team for generating proposals codes which indicated a varity of information related to the generated code like ;- proposal type,Technical Approver,proposal number,client source,sales agent name and additional information like :- Client Name, Proposal Date, Propsal Value.

## installation

Proposal Api is easy to use application doesn't require alot of configrations, now we gonna go through these installation.

- git clone https://github.com/Kamel420/proposals.git
- cd proposals/
- composer install
- cp .env.example .env
- change ur .env fields DB_DATABASE,DB_USERNAME,DB_PASSWORD
- php artisan migrate
- php artisan passport:install => password_grant client key needed for generated tokens.
- php artisan key:generate
- use the web route to fastly regsiter new user 
- now you good to go.


## Main Components & Hints

This is the main components of the proposals api and the specific parts responsable for handling its functionality .

- **Transformation** : UsersCollection/UserResource is being handled in App\Http\Resources\Users AND ProposalsCollection/ProposalsResource is being handled in App\Http\Resources\proposals.
- **Requests** : proposals requests is being handled by  App\Http\Requests\ProposalsRequests.php
- **Permissions** : users privileges is being handled by App\Http\Middleware\PermissionsWare.php
- **Exceptions** : most of the exception is being handled by App\Exceptions\ExceptionTrait.php 
- For fast **Testing** there is a folder in the project root folder called : **postman_collection** it contains all the end points just before get use it change the **{{auth}}** variable in the postman environemnt to your recently generated token .


## End-Points 

- Token

    * Url : http://localhost:8000/oauth/token
    * Purpose : this endPoint is used to generate token which is required for all other endPoints, This application uses PassPort  for Authentiction

    * Request Type : POST Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json 

    * Body : \
{\
	"grant_type" : "password",\
	"client_id" : "2",  => from `oauth_clients` table after migrate/passport install\
	"client_secret" : "H3s2R5Osu4wlMWPZy52P3NwX9UXIQ6G7hjTeiDSs", => from `oauth_clients` table after migrate/passport install\
	"username" : "m.kamel.career@gmail.com", => recently registerd mail , i didn add register api yet you can use the web url to fastly register new user\
	"password" : "123456", => recently registerd mail's password\
}

**Proposals EndPints** 

- List
    * Url : http://localhost:8000/api/proposals
    * Purpose : this endPoint is used to list all generated proposals
    * Function : ProposalsController@index
    * Request Type : GET Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

- Show
    * Url : http://localhost:8000/api/proposals/{id}
    * Purpose : this endPoint is used to show a proposal
    * Function : ProposalsController@show
    * Request Type : GET Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

- Create
    * Url : http://localhost:8000/api/proposals
    * Purpose : this endPoint is used to Create a proposal
    * Function : ProposalsController@store
    * Request Type : POST Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

    * Body :\
{\
	"proposal_number" : "0002", => could be 0001 or 0002\
	"proposal_type" : "digital marketing", => could be  web development, digital marketing or web product . in small letters\
	"technical_approver" : "Mostafa Kamel", => first name and last name only\
	"client_source" : "digital campaign", => could be recap, digital campaign . in small letters\
	"sales_agent" : "ahmed essam", => could be yassmin hassan , ahmed essam. in small letters\
	"value" : "12345" => entered as desired\
}

- Delete

    * Url : http://localhost:8000/api/proposals/{id}
    * Purpose : this endPoint is used to Delete a proposal
    * Function : ProposalsController@destroy
    * Request Type : Delete Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

- Decode Code

    * Url : http://localhost:8000/api/get_proposal_code
    * Purpose : this endPoint is used to decode a proposal code to its original informations
    * Function : ProposalsController@fetchCode
    * Request Type : Post Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

    * Body \
{\
	"code" : "DMLL-0002-DCAE" => must has been generated before. \
}

**Users EndPints** 

- List Users

    * Url : http://localhost:8000/api/users
    * Purpose : this endPoint is used to list all users
    * Function : UsersController@index
    * Request Type : Get Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

- Show User

    * Url : http://localhost:8000/api/users/{id}
    * Purpose : this endPoint is used to show a users
    * Function : UsersController@show
    * Request Type : Get Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

- Change a user Permission/Privileges

    * Url : http://localhost:8000/api/users/{id}/change_permission
    * Purpose : this endPoint is used to change a permissions/privileges for a user
    * Function : UsersController@ChangePermissions
    * Request Type : Patch Request

    * Headers : 
Accept : Apllication/json , 
Content-type : Apllication/json,
Authorization : {{Beare Token}} 

    * Body\
{\
	"can_view" : 1 => can_view,can_list,can_delete,can_create permissions supported keys and 0/1 supported values\
}

> This Application not for commirical usage it was implemented for self development and get to know new features of laravel framework so and pull requestes are more than welcome and any issue will be considered , i hope later i can add more functionality on the go to make it better , it's open source thats mean it's for all , i hope you gunna like it . 
