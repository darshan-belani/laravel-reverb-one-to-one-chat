# Laravel Real-Time Chat Application

This project is a real-time chat application with bootstrap, Reverb, and Laravel. Reverb for real-time capabilities.

## Installation
Need to PHP version 8.2 or above, laravel version 11 or above  

1. Clone the repository:
    ```bash
    git clone https://github.com/darshan-belani/laravel-reverb-one-to-one-chat.git
    cd laravel-reverb-one-to-one-chat
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Set up your environment file:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Configure your database in the `.env` file:
    ```env
    DB_CONNECTION=
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

5. Run migrations:
    ```bash
    php artisan migrate
    ```

6. Install Reverb
    ```bash
   php artisan install:broadcasting
    ```
  Next, After running the above command follow the steps and install the dependencies.
 
6. Start Reverb and start queue command for getting real-time message
    ```bash
   php artisan reverb:start 
   php artisan queue:work
    ```

### Running the Application

- **Start laravel Backend:**
    ```bash
    php artisan serve
    ```

- **Start the Frontend:**
    ```bash
    npm run dev
    ```

- **Open your browser and navigate to:**
    ```
    http://127.0.0.1:8000/
    ```
