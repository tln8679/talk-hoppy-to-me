# talk-hoppy-to-me

## Overview:
Talkhoppyto.me is a “mobile-first” designed web applications for beer connoisseurs to share their hobby. 
A new visitor to the website would first register their account. Upon registration, the user can upload a profile picture. The profile picture could then be changed at any point. The user can search through a database of over 800 beers and either log a beer, love a beer, or save it for later. Logging the beer creates a user post, which includes a given rating and a comment. This post will show up in the global feed and the rating will update the beers average rating.
A user can search for fellow friends and follow them. The user can then view their new friends profile and see what kind of beers they like. When the user goes to their feed they can toggle between a global feed and a feed of only the users they are following.
Within the beer search page, a user can filter and search by name, brewer or style. As a user logs beers, he or she will see some data analysis on their profile showing the styles they drink the most and the percentage of that style out of their total logged count.
If the user cannot find a certain beer, they can go to the suggestions page that is linked to in the footer. From there they can send in a request to add a new beer. The user could also suggest anything they like. 
Talkhoppyto.me also has an interface for admins. If the user is logged in as an admin they will see a toggle in the footer of the page. From the admin interface, the admin can view all suggestions ordered by oldest. The admin can then add breweries and new beers. The admin can also view all users and choose to delete a user, if needed. 

## Known problems:
	Talkhoppyto.me does not have a password change or forgot password functions. If a user forgets their password, they will need to create a new account.
	Talkhoppyto.me allows a user to love a beer that they have not logged yet. We could in the future use a trigger to disallow or use some php processing to send an error message. Talkhoppyto.me does have a similar trigger to remove beers from the Later list, if the user had put that beer in his later list to try.
  A delete suggestion function should be added to administration/ViewSuggestions.php


Final ERD:
