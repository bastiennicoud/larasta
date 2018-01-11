# LARASTA

"Stage" application with laravel.

## Set up development

### 1. Fork the repo
Fork on your github account the original repo from XCarrel/larasta.

### 2. Clone it
Clone your fork of larasta on your local machine.

```bash
git clone https://github.com/USERNAME/larasta.git FLODER
```

### 3. Set up homestead
Follow the installation steps for homestead [here](https://laravel.com/docs/5.5/homestead).

Once homestead are installed, you must add to your homestead configuration the path to your fresh clone of larasta.

Homestead.yaml :
```yaml
# Set up the synced folders
folders:
    - map: /path/to/your/local/clone/of/larasta
      to: /path/in/the/vm

# Set up the nginx virtualhost
sites:
    - map: domainname.dev
      to: /path/in/the/vm
```

### 4. Install dependencies
Go to your project folder and run the installation of laravel dependencies.

```bash
cd /path/to/your/local/clone/of/larasta

# install composer dependencies
composer install

# install the npm dependencies
cd public && npm i
```

### 5. Set up your application key
When the dependencies are installed you must duplicate the ``.env.example`` file and rename it to ``.env``.

Then open your ``.env`` file and complete the informations four our specific development environnement (db connexion).

Finally, for laravel to work properly, you must generate the application key.

```bash
cd /path/to/your/local/clone/of/larasta

php artisan key:generate
```

### 6. Create and seed the database

- Drop schema `app_internships` on your server
- Synchronize (i.e: create) schema using `database/Stages v2.mwb` with Workbench
- Execute script `database/testdata.sql`

### 7. Simulate intranet login

For your tests, you will want to try working as different users with different privilege levels

You can do that using the ``.env`` file, adding the following keys:

```
USER_ID=1234
USER_INITIALS='ABC'
USER_LEVEL=1
```

Then use the static method `Environment::currentUser()` in your code

### 8. Add the Intranet API key (optional)
If you plan on synchronising your local database with the Intranet (persons), you need the application key and the secret.
Add 2 environment variables in the ``.env`` file of the project:

```
API_KEY=...
API_SECRET=...
```

### 9. Add the GoogleMap API key (optional)
If you plan on using the distance matrix function, you must provide the GoogleMap API key:

```
API_GOOGLE_MAP=AIzaSyBRFbQtojevcenB9g0knU6W_9kL0eWu4Vo
```

**WARNING**: We have a quota on the requests and it goes for the whole school. The application can be pretty greedy, so use this feature with care and consideration for other users.
### Ready for development
Now, your fork of larasta is working on your machine, you can acces it by the domain name you specified in the Homestead configuration (Don't forget to add it on your host file).

If your have problems, you can check the laravel documentation :  
[Installation](https://laravel.com/docs/5.5/installation)  
[Configuration](https://laravel.com/docs/5.5/configuration)