# A1: Collaborative Q&A

## Goals, Motivation, Business Context and Environment
Our main goal (and motivation) is to solve people's questions by providing a connection between those who need help and those that 
 have the knowledge. The website will work like a forum where the users who need help can post questions (by creating a new thread in
 the forum). To post a question, a user must be registered to the forum. The question will be listed in the forum for whoever has
 knowledge to answer them. To answer a question, a user must be registered to the forum.
	It is possible to view questions and answers to a question (forum thread) even without being registered.
	The forum is also aimed to provide information to people that don't know it and may end up visiting it by searching for a 
  specific question on a search engine. They can quickly and easily find the solution to their problem.
	The thematic of the forum will be about software development (programming).

	
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
  User with read only permissions. He can only read posts (questions, answers and comments) but cannot 
post nor vote.
### Banned
  Inherits the functionalities from Visitor. Can authenticate, however post and vote permissions are not 
granted, is also able to view remaining time on ban.
### Authenticated
  Inherits the functionalities from Visitor. Moreover, user that can add, vote posts and mark their own 
as solved in the forum.He has a profile, with a rating to his questions and answers. 
### Administrator
  Inherits the functionalities from Authenticated. Moreover it's responsible for the management of users 
and for some specific supervisory and moderation functions. Operations like to ban users, delete any post,
close any post, mark any post as solved, move posts between categories, etc.
	
	
***
## Revision history
 
Changes made to the first submission:

***
 
###  GROUP1751, 12/02/2018
