# Messenger-Web-Application
In this personal project, I created a messaging website using PHP and MySQL.

Features of the website:
- login/register/logout
- home page:
  - contains the names of all the people that the user is talking to
  - contains the option to message or delete each person
  - contains a search bar to message any user in the database
- message page:
  - each message has the content and a time stamp
  - the user has the option to type the message, attach pictues or .txt files and send them
  - once a picture is sent, the user can click on that picture to enlarge it
  - used JS AJAX to load the message page every 1 second to update the page (without refresh) once a new message is sent
  
Database had 2 tables:
1. user: USER_ID(PK), USER_NAME(UNIQUE), PASSWORD(HASHED)
2. message: MESSAGE_ID(PK), CONTENT, SENDER_ID(FK), RECIPIENT_ID(FK), DATE

Screenshots of website:

![1](https://github.com/RamizFaragalla/Messenger-Web-Application/blob/master/1.PNG) ![2](https://github.com/RamizFaragalla/Messenger-Web-Application/blob/master/2.PNG)
