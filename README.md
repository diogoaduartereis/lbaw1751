# A1: Collaborative Q&A

## Goals, Motivation, Business Context and Environment
Our main goal (and motivation) is to solve people's questions by providing a connection between 
those who need help and those that have the knowledge. The website will work like a forum where 
the users who need help can post questions (by creating a new thread). To post a question, a user 
must be registered. The questions will be listed in the Q&A platform for whoever has knowledge to 
answer them. To answer a question, a user must be registered as well.
It is possible to view questions and answers even without being registered.
The Q&A platform is also aimed to provide information to people that don't know it and may end up 
visiting it by searching for a specific question on a search engine. They can quickly and easily 
find the solution to their problem.
	The thematic of the Q&A platform will be about software development (programming).

	
## Main Features
### Authentication
 - Log In
 - Sign Up
 - Log Out
 - Secure Authentication
  
### Management
 - Profile editing
 - Profile picture
 - Password changing
 - Account closure
 - User bans by system Administrator
 - User timeout by system Administrator
 - User profile edits by system Administrator

### Q&A Systems
 - Submitting questions
 - Submitting answers
 - Commenting
 - Voting on questions and answers (+1/-1)
 - Deleting questions thread as question poster or System Administrator
 - Deleting answer as answer poster or System Administrator
 - Deleting comment as comment poster or System Administrator
 - Marking answers as correct as question poster or System Administrator
 - Closing thread as questions poster or System Administrator
 - Adding Tags to the Thread as question poster or System Administrator

### User profiles
 - Adding a public description
 - Having a score based on question and answer score
 - List of archived questions
 - List of active questions
 - List of Answers

### Questions
 - Public score
 - Public Date of post
 - Editing question as question poster
 - Public Number of Views
 - Public username of poster
 - Public Comments

### Answer
 - Public score
 - Public comments
 - Public date of post
 - Public username of poster
 - Editing answer as answer poster

### Search Engine
 - Searching by question name
 - Searching by question Tags
 - Searching by question score
 - Searching by question poster score
 - Searching by mix of previous search methods

### Technical
 - Responsive CSS design
 - Secure environment
 - Fast and efficient environment
 - Pleasing environment
 
 
 ## User Profiles
### Visitor
User with read only permissions. He can only read posts (questions, answers and comments) but cannot post nor vote. He can also create an account and log in. He cannot logout.
### Banned
Cannot authenticate, so post and vote permissions are not granted. He is only able to view the remaining time of his ban. He cannot logout.
### Authenticated
User that can read as well as add, vote posts and mark their own as solved in the Q&A platform. He has a profile, with a rating to his questions and answers. He can logout.
### Administrator
Inherits the functionalities from Authenticated. Moreover, is responsible for the management of users and for some specific supervisory and moderation functions. Operations like banning users, deleting posts, closing posts, marking posts as solved, moving posts between categories, etc. He can logout.
	
	
***
## Revision history
***
 
###  GROUP1751, 12/02/2018
 - Davide Henrique Fernandes da Costa, up201503995@fe.up.pt
 - Dinis Filipe da Silva Trigo, up201504196@fe.up.pt
 - Diogo Afonso Duarte Reis, up201505472@fe.up.pt
 - Tiago José Sousa Magalhães, up201607931@fe.up.pt
