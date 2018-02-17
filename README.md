# A1: Code Home

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
 - Added title to the platform. 19-02-2018
***
 
###  GROUP1751, 12/02/2018
 - Davide Henrique Fernandes da Costa, up201503995@fe.up.pt
 - Dinis Filipe da Silva Trigo, up201504196@fe.up.pt
 - Diogo Afonso Duarte Reis, up201505472@fe.up.pt
 - Tiago José Sousa Magalhães, up201607931@fe.up.pt
 
 
 
 
 
 A2: Actors and User stories

This artifact contains the specification of the actors and their user stories, serving as agile documentation of project requirements.

Actors
For the Collaborative Q&A system, the actors are represented in Figure 1 and described in Table 1.
 
Figure 1: Actors


Identifier	Description	Examples
User	Generic user. Has access to public information, such as questions and answers in the Q&A Platform.	n/a
Visitor	Unauthenticated user; Can register itself or authenticate in the system. Inherits all possible actions from User.	n/a
Authenticated	Authenticated user; Can consult information, post new questions and reply to existing ones and is able to logout from his account. Inherits all possible actions from User.	lbaw
Banned	Cannot authenticate, so post and vote permissions are not granted. He is only able to view the remaining time of his ban. He cannot logout. Inherits all possible actions from User.	lbaw
Administrator	Inherits the functionalities from Authenticated. Moreover, is responsible for the management of users and for some specific supervisory and moderation functions. Operations like banning users, deleting posts, closing posts, marking posts as solved, moving posts between categories, etc.	admin
API	External APIs that can be used to register or authenticate into the system.	Google, Facebook
Identifier	Name	Priority	Description
US01	View Question Thread	High	As a User I want to be able to view question threads to have my questions answered
US02	Filter Questions by Name	Medium	As a User I want to be able to filter question threads by how similar their name is to my search query in a list format sorted downwards by similarity
US03	View Question Score	High	As a User I want to be able to view a question thread's current vote score as an integer
US04	View Answer Score	High	As a User I want to be able to see the current vote score of an answer to a question thread as an integer
US05	View User Overall Score	High	As a User I want to be able to see a user's current overall vote score as an integer
US06	View Comments to Q&A	High	As a User I want to be able to see comments to questions and answers as small boxes with the comment
US07	View User Profiles	Medium	As a User I want to be able to see a user's profile on a specific page with all relevant information
US08	Filter Questions by Tags	Medium	As a   User I want to be able to filter question threads by their tags and get a list sorted downwards by tags
US09	Filter Questions by Question Score	Medium	As a User I want to be able to filter question threads by their question’s score and get a list sorted downwards by Score
US10	Filter Questions by Author Score	Medium	As a User I want to be able to filter question threads by the vote score of the author in a list ordered downwards by vote score
US11	Filter Questions by Mix of Other Methods	Medium	As a User I want to be able to filter question threads by a mix of other available filter methods as a list sorted downwards according to the mix of methods
US12	View Thread's Number of Views	Medium	As a User I want to be able to view the number of views of a given question thread as an integer
US13	Secure Environment	Medium	As a User I want my activity to not be revealed to external 3rd parties to keep my privacy
Table 1: Actor description

User Stories
For the Collaborative Q&A system, consider the user stories that are presented in the following sections.

User
Table 2: User user stories
Visitor
Identifier	Name	Priority	Description
VS01	Register in the Q&A platform	High	As a Visitor, I want to register myself into the system, so that I can authenticate myself into the system.
VS02	Login in the Q&A platform	High	As a Visitor, I want to authenticate into the system, so that I can access privileged information.
Table 3: Visitor user stories
Authenticated
Identifier	Name	Priority	Description
AS01	Post New Question	High	As an Authenticated user I want to able to create a new question on the Q&A platform. Equivalent to creating a new thread in a forum.
AS02	Post New Reply	High	As an Authenticated user I want to able to create a new answer to an existing question (reply to a question).
AS03	Edit Previously Posted Question	High	As an Authenticated user I want to able to edit a previously posted question by the same user. User is only able to edit questions posted by him.  Security verifications are required to make sure that a user cannot edit other users' answers.
AS04	Edit Previously Posted Answer	High	As an Authenticated user I want to able to edit a previously posted answer by the same user. User is only able to edit answers posted by him. Security verifications are required to make sure that a user cannot edit other users' answers.
AS05	Change Profile Photo	High	As an Authenticated user I want to able to change my profile photo.
AS06	Change Name	High	As an Authenticated user I want to able to change the username displayed to other users (not the ID used to login).
AS07	Vote on an answer	High	As an Authenticated user I want to able to vote on an answer to a question. The vote can be positive or negative representing whether he thinks the answer is good or not.
AS08	Add a profile description	High	As an Authenticated user I want to be able to add a description to my public profile, so any visitor can know me
AS09	Log Out	High	As an Authenticated user I want to be able to sign out and become a visitor
AS10	Change Password	High	As an Authenticated user I want to be able to change my password so that I can use it to login
AS11	Close Account	Medium	As an Authenticated user I want to be able to close my account so that it is no longer usable
AS12	Commenting	High	As an Authenticated user I want to be able to add small comments to questions and answers
AS13	Remove Question	High	As an Authenticated user I want to be able to remove a question I have previously posted
AS14	Remove Answer	High	As an Authenticated user I want to be able to delete an answer to a question I posted
AS15	Remove Comment	High	As an Authenticated user I want to be able to delete a comment I posted on a question
AS16	Mark Answer as Correct	High	As an Authenticated user I want to be able to mark an answer to my question as correct
AS17	Close Question Thread	High	As an Authenticated user I want to be able to close a question thread I made so that no more comments or answers are posted
AS18	List of Question	High	As an Authenticated user I want to have a list of all the questions I posted both active and archived, that have not been deleted
AS19	List of Answers	High	As an Authenticated user I want to have a list of non-deleted posts I have answered to or commented on.
AS20	Number of Views	Low	As an Authenticated user I want to track how many times my public questions have been viewed.
Table 4: Authenticated user stories

Banned
Identifier	Name	Priority	Description
BS01	Login Attempt	High	As a banned user I want to still be able to try to login to the platform. As a banned user, my login should be rejected, not allowing me to login, displaying the remaining time on the ban. 
Table 5: Banned user stories

Administrator
Identifier	Name	Priority	Description
SAS01	Remove Comments	High	As an Admin, I want to be able to remove a comment, so that I can remove inappropriate comments.
SAS02	Remove Posts	High	As an Admin, I want to be able to remove a post, so that I can remove inappropriate posts.
SAS03	Close Posts	High	As an Admin, I want to be able to close a post, when the question has already been answered
SAS04	Change Posts' Tags	High	As an Admin, I want to be able to change a post's tags to better suit its content
SAS05	Ban Users	High	As an Admin, I want to be able to ban a user, so that he can no longer access the Q&A platform. Posting new questions and answers isn't allowed.
SAS06	Unban Users	High	As an Admin, I want to be able to unban a given user so that he can access the platform again
SAS07	Change Users' Profile	High	As an Admin, I want to be able to edit a user's profile if necessary, to follow platform rules
SAS08	Mark Answers as Correct	High	As an Admin, I want to be able to mark any answer to a question as correct
Table 6: Administrator user stories
Annex: Supplementary requirements 
This annex contains business rules, technical requirements and other restrictions on the project.

Business rules
A business rule defines or constrains one aspect of the business, with the intention of asserting business structure or influencing business behavior. 
Identifier	Name	Description
BR01	Login	The user should not be able to login, when he is not logged out.  
BR02	Logout	I should not be able to log out, when I’m not logged in.
BR03	Register	The user should not be able to register, when he is logged in.  
BR04	Session timeout	The authenticated user session should be destroyed after 1 hour.
BR05	Ban time	The ban time is defined, accordingly to the severity of the irregularity, by the system administrator.
BR06	Inappropriate language	The authenticated user can turn to a banned user when uses inappropriate language.
BR07	Negative Score	The authenticated user can turn to a banned user when having a big number of answers with negative score (indicating, for example, he is answering and has no knowledge for it).
BR08	Inappropriate Behavior	An authenticated user can be banned for concurrent negative attitude towards other users of the platform
BR09	Administration of tags	System administrators hold the right to change as questions tags and categories as they see fit to better suit the questions and give it more exposure
BR10	Administrative deletion of post	System administrators hold the right to delete posts of any kind as they see fit to better follow the platforms rules
BR11	Administration of descriptions	System administrators hold the right to edit individual user descriptions as they see fit to better follow platform rules
BR12	Administration of posts	System administrators have the right to close posts as they see fit to follow the rules of the platform
BR13	Duplicate posts	Duplicate posts will be administratively closed and linked first time the same question was asked and marked as solved
BR14	Harassment	Harassments is considered negative attitude and is therefore a reprehensible offense
BR15	Racism	Racism (outside of memes and jokes) is considered negative attitude and is therefore a reprehensible offense
BR16	Malware	Links to malicious content and or any other means of spreading malware is a reprehensible able offense with a permanent ban punishment type
BR17	Spam	Spamming is considered negative attitude and is therefore a reprehensible offense
BR18	Unrelated Questions	Posting questions or answers that are not directly connected to software engineering will lead to administrative removal of said content
BR19	Inappropriate Username	Inappropriate usernames lead to either a ban or a forced username change

 Technical requirements
Technical requirements are concerned with the technical aspects that the system must meet, such as performance-related issues, reliability issues and availability issues.

Identifier 	Name 	Description 
TR01 	Availability 	The system must be available 99 percent of the time in each 24-hour period 
TR02 	Accessibility 	The system must ensure that everyone can access its pages independently of the Web browser they use
TR03 	Usability 	The system should be simple and easy to use 
TR04 	Performance 	The system should have response times shorter than 2s to ensure the user's attention 
TR05 	Web Application 	The system should be implemented as a Web application with dynamic pages (HTML5, JavaScript, CSS3 and PHP) 
TR06 	Portability 	The server-side system should work across multiple platforms (Linux, Mac OS, etc.) 
TR07 	Database 	The PostgreSQL database management system must be used 
TR08 	Security 	The system shall protect information from unauthorized access using an authentication and privilege verification system 
TR09 	Robustness 	The system must be prepared to handle and continue operating when runtime errors occur 
TR10 	Scalability 	The system must be prepared to deal with the growth in the number of users and corresponding operations 
TR11 	Ethics 	The system must respect the ethical principles in software development (for example, the password must be stored encrypted to ensure that only the owner knows it) 

Restrictions
Identifier 	Name 	Description 
R01 	Deadline 	The system should be ready to be used in the last week of classes
R02	Work Equity	The system should be made equally by all team members
A restriction on the design limits the degree of freedom in the search for a solution. 


Group
•	Davide Henrique Fernandes da Costa, up201503995@fe.up.pt
•	Dinis Filipe da Silva Trigo, up201504196@fe.up.pt
•	Diogo Afonso Duarte Reis, up201505472@fe.up.pt
•	Tiago José Sousa Magalhães, up201607931@fe.up.pt

