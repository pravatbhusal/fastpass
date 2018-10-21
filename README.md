# FastPass
A mobile app that speeds-up the boarding pass process using facial recognition.
This program was created for HackTX, specifically for American Airlines.

# Developers
- Pravat Bhusal (React Native & MySQL Developer)
- Michael Kasman (Full-Stack & MySQL Developer)

# Application Set-up
### 1. Web-Server
- Clone or download the .zip of this repository
- Inside the src/server folder, place all php files into your web-server
- Open the App.js file in the root directory
- Change the serverURL variable to your server's URL

### 2. Database Configuration
- Inside the src/server/db folder, export the fastpass.sql file into your MySQL database
- Inside the src/server/db folder, open the dbconnection.php file and configure the variables to your database credentials

### 3. Test React Native App
- Open a new terminal in this project's directory
- Type "npm install" or if you have yarn use "yarn install"
- Now run the Expo development server using "expo start"

### 4. Set-up Microsoft Azure Face API to receive an API key
- https://azure.microsoft.com/en-us/services/cognitive-services/face/
- Change the "Ocp-Apim-Subscription-Key" in findSimilarFace.php and addFace.php to your Face API key

### 5. Create the "customer_face_list" face list id from the URL below
- https://eastus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f3039524b/console

### 6. Load the create_data PHP files in the server folder
- Inside the src/server/create_data folder there are PHP files you must run to initiate the database

### 7. chmod permissions onto the face_api and media directory
- In the src/server/media and src/server/face_api folders do a "chmod 777 -R ." to give
permission to read and write
