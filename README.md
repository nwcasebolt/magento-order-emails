# magento-order-emails
Provides an admin menu to resend select order confirmation emails

# Story
As a user with access to the Magento 2 admin panel, I want to select as many orders as I want and send order confirmation emails for them manually.

# Installation
Under your app/code directory, create an Nwcasebolt/OrderEmails directory structure. Add these files inside your OrderEmails subdirectory.
From command line, execute:</br></br>
`bin/magento setup:upgrade`</br>
`bin/magento setup:static-content:deploy`</br>
`bin/magento cache:flush`</br>

# Usage
Log into the admin panel and navigate to SALES > Order Emails. Filter and/or sort orders by your desired criteria. Click "Send Email" on individual orders to (re)send that order's confirmation email, or select multiple orders and choose "Send" from the Mass Action menu to (re)send order confirmation emails again for all those orders.

# Notes
This module solves for a problem where multiple order confirmation emails need to be sent manually, and are not being handled by a cron. Because of this, there is no batching or asynchronous processes happening under the hood. The greater the number of orders emails to send, the longer this will take. As a general benchmark, on my local project it took just over 4 minutes to send 108 emails.
