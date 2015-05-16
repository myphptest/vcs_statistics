## PHP Version Control System (VCS) - Service API
## #############################################

## This is used to manage statistics API of different type of VCS.

## Software & Application Used:
********************************
## PHP above 5.2
## CURL

## Plugin Structure
*********************
## lib\ it includes all shared library files among VCS
## type\ it includes VCS service type file 


## Steps to use
****************

## 1. include the common files:
## autoload.php - to automatically autoload the file
## constants.php - to use constants value in system
## process.php - to process the given statistic of VCS (Github/ bitbucket/ any)

## 2. Take and validate user inputs to process statistics service api
      Like username, password, repository url, contributor name, statistic type

## 3. Set the service requested in the repository url of user inputs and 
      call the service method according to the statistic type given in user input

## 4. Show the response to user

## For now, Enjoy this service to get the Github/Bitbucket contributors commit count




