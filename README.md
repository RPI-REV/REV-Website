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

First, you'll need a key.ini file. If you don't have one given to you, 
make this file in the root directory and name it key.ini

    [database]
    dbname = "DB"
    user = "user"
    password = "password"

Note that with this you can't actually use the 
application, because you need to be set up with the 
db.

Now, install the PHP dependencies with

    composer install

then build some of the project settings with 

    composer build
    
Finally, start your local version of the website with

    composer start

and navigate to `localhost:8000` to see the website!

Feel free to make any changes from there.