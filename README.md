
# Google Search Keyword Application

## Getting started

### System requirements
- PHP >=8.2
- Composer >=2.5
- MySQL >=5.8 or PostgreSQL >=14.6
- NodeJS >=12.22
### Installation
1.  Clone source code from Github repository [Link](https://github.com/paladin3895/google-search.git)
2. Change directory to source code directory
3. Run `composer install` to download code dependencies
4. Copy `.env` file from `.env.example`
5. Update `.env` config to match your database settings
| PostgreSQL | MySQL |
|---------------|----------|
|![PostgreSQL](https://s3.us-west-2.amazonaws.com/secure.notion-static.com/c1ce10cc-68fd-4b1c-b479-7855296f2156/Screenshot_from_2023-01-18_14-14-48.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Credential=AKIAT73L2G45EIPT3X45/20230118/us-west-2/s3/aws4_request&X-Amz-Date=20230118T071643Z&X-Amz-Expires=86400&X-Amz-Signature=30d0b1c5a8cbb93fb502d8a9a066bcde791a065f806b70344b8fbe903180a416&X-Amz-SignedHeaders=host&response-content-disposition=filename=%22Screenshot%2520from%25202023-01-18%252014-14-48.png%22&x-id=GetObject) |![MySQL](https://s3.us-west-2.amazonaws.com/secure.notion-static.com/9a856d47-df78-4dc0-a306-9c28ff715f81/Screenshot_from_2023-01-18_14-14-00.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Credential=AKIAT73L2G45EIPT3X45/20230118/us-west-2/s3/aws4_request&X-Amz-Date=20230118T071636Z&X-Amz-Expires=86400&X-Amz-Signature=717df1108b484e98936d9dca3c46ff6681a0a9b72bd948c754a8f077a870cffd&X-Amz-SignedHeaders=host&response-content-disposition=filename=%22Screenshot%2520from%25202023-01-18%252014-14-00.png%22&x-id=GetObject) |
6. Run `php artisan serve` to start the web server
7. You can also run the unit tests by this command `php artisan test`
8. The source code already contained built frontend code (JS and CSS) but if you want to compile for development:
```
# install frontend dependencies
yarn
# compile and hot reload frontend code
yarn dev
```

## Application Features


1.  Authenticate user:

-  Login by email and password
-  Register user form
-  Forgot password (sending email to user)

2.  Keyword dashboard to allow users to view the list of their uploaded keywords. For each keyword, users can also view the search result information stored in the database.

3.  Upload keyword CSV file: The uploaded file contains keywords. Each of these keywords will be used to search on [http://www.google.com](http://www.google.com) and will start running as soon as they are uploaded and will update web app in real-time.

4.  Keyword results: For each search result/keyword result page on Google, store the following information on the first results page:

-  The total number of AdWords advertisers on the page.
-  The total number of links (all of them) on the page.
-  The total search results for this keyword, e.g., About 21,600,000 results (0.42 seconds)
-  HTML code of the page/cache of the page.

## Tech stack

1.  Backend PHP framework: Laravel 9

2.  TDD framework: PHPUnit

3.  Database: PostgreSQL

4.  Frontend framework: Vue3 + TailwindCSS + Vite

## Technical Solutions:

### To work around the limitations of mass-searching keywords, as Google prevents it.

I researched and applied these 3 solutions:

-   Rotate from a pool of IP addresses (obtained from a free/paid proxy service) for each search query
-   Rotate user-agent for each search request
-   Using a queue to process search request and retry failed request

### One of the goals of the code challenge is to make applicants work on data scraping.

The HTML data returned from Google was parsed into DOM Document (PHP DOM library) and required data were scraped by using XPath (Links and Adwords) and Regular expression (Total results).

### (Optional) The following API endpoints must be implemented:

I have implement API endpoints for:

1.  User authentication to obtain access token
2.  Keywords (listing, add new and get keyword results and HTML page)
3.  Upload keywords CSV file
The Web app also communicated with the Backend via the API endpoints

## Demo app

The app is already deployed on DigitalOcean. To test the demo app, please add this record to your `/etc/hosts` file (Linux or Mac) or `C:\Windows\System32\drivers\etc\hosts` (Windows)
```
# IP of server  domain name
206.189.152.241  google-search.develop
```
Then you are good to check out the demo app at [http://google-search.develop](http://google-search.develop)

1.  Register an account here: [http://google-search.develop/register](http://google-search.develop/register)
2.  After that, login to your account here: [http://google-search.develop/login](http://google-search.develop/login)
3.  You will be redirected to the Dashboard page, where you can test:

-  Upload search keywords by CSV file
-  Interact with keyword list on the left and update in real-time
-  View the keyword’s results and see the HTML page by click on a keyword![](https://lh3.googleusercontent.com/cxRJEwrEHqUBUHa7lVuGMdPR7DcngEtCY4SfVqnVOXqK4wAyBfQHPX193n765xnf1WH8KbJP2RVYtV2yJG1xnfsDPnP_DoWJq0FXVEfUJe6EU6RKUGFbjcy-ORTAd7o2tRpb-GLapbpUllmiJPywl14dQ1ZClVUuocOOkGJY6-enozcce-8BLlrEBfcCMg)

