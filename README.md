# website

REV Website

## Getting Started

# Setup

Tools you'll need are npm, PHP, git, and composer.

So first thing you'll want to do is clone the repo. If you've never
used git before, I recommend the GitHub GUI. Or, if you know what you're
doing 

    git clone https://github.com/RPI-REV/website.git
    cd website
	
## Bower

If you don't already have node, I highly suggest installing it.

    npm install -g bower
  
Now that we have bower, time to install our bower dependencies with 

    bower install 

## Composer

You can run the application without configuring the DB and CAS, 
but user functions will always return `develp`. To configure the DB, go to
`app/config/config.json` and edit the db config to 

     {
        "db_settings": {
            "host": $myhost,
            "dbname": "solarrac_website",
            "user": $myuser,
            "password": $password
        }
     }

and to configure CAS for RPI for example, use

    {
        "cas_settings": {
            "host": "cas-auth.rpi.edu",
            "port": 443,
            "method": "/cas"
        }
    }
    
The final setting is `club_api_key`, which is the secret key for the RPI union 
querying users. If you have a club, you can find this at `clubs.union.rpi.edu`, 
or you can set it to `false` and all user queries will return a test user. To 
set `club_api_key`,

    {
        "club_api_key": $secret_key
    }

Now, install the PHP dependencies with

    composer install

then build some of the project settings with 

    composer build
    
Finally, start your local version of the website with

    composer start

and navigate to `localhost:8000` to see the website!

Feel free to make any changes from there.