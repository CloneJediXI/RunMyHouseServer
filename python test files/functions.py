import sqlite3
import random
import datetime
conn = sqlite3.connect('var/database.db')

c = conn.cursor()

""" 
Adding entires to database
 """
# add users
def add_user():
    unique_id = ID()
    new_username = input("Enter username:") # later we need to make sure this is not open to SQL injection
                                            # Not able to add username that is already there
    

    password = input("Enter password:")
    name = input("Enter first and last name:")
    email_address = input("Enter email address:")
    #if is_a_new_username(new_username) == True:
    try: 
        insert_users(unique_id, new_username, password, name, email_address)
    except:
        print("Username already in use.")

# add reviewers
def add_reviewers():
    reviewer = input("Enter reviewer name: ")
    currentDay = datetime.now().day
    currentMonth = datetime.now().month
    currentYear = datetime.now().year
    day = ""
    day += str(currentMonth)+ "/" + str(currentDay) + "/" + str(currentYear)
    uid = c.execute("SELECT user_id FROM users WHERE username = ?",(reviewer,))
    uid = c.fetchone()[0]
    contractor_name = input("Enter contractor name:")
    star_rating = input("Enter rating of contractor:") # need to catch if not number
    comment = input("Enter review:")
    insert_review(uid, reviewer, day, contractor_name, star_rating, comment)
    
# add services
def add_services():
    # all of these values will eventually be changed so that the user isnt inputing information
    poster = input("Enter poster name: ")
    uid = c.execute("SELECT user_id FROM users WHERE username = ?", (poster,))
    uid = c.fetchone()[0]
    ticket_id = ID()
    ticket_status = "In progress"
    current_cost = "20 Republic Credits/hr"
    highest_bidder = "Atlas Corp"
    date = ""
    insert_services(uid, poster, ticket_id, ticket_status, current_cost, highest_bidder, date)
   
# add payment information
def add_payment_info():
    unique_id = "Temporary" #temp username
    card_holder = input("Enter name on card:")
    card_number = input("Enter 16 digit number on card:") # starting here we need to have checks for none numbers
    month = input("Enter month on card:")
    year = input("Enter year on card:")
    csv = input("Enter csv:") # last to need check for none numbers in this function
                                # for now assume no errors will be made

    insert_card_info(unique_id, card_holder, card_number, month, year, csv)
    print("Not implemented")

# add contractors
def add_contractors():
    contractor_id = id("")
    company_name = input("Enter company name:")
    type_of_service = input("Enter the service provided") # will later be pull from account creation
    password = input("Enter your password")
    overall_stars = 0.0 # is number not text
    insert_contractors(contractor_id, company_name, type_of_service, password, overall_stars)

# add bank information
def add_bank_info():
    contractor_id = "Temporary" # Needs way to get the users id.
    routing_number = input("Enter bank routing number:")
    account_number = input("Enter account number:")

""" 
Removing entries from database
 """

def remove_user():
    username = input("Enter user to be removed:")
    c.execute("SELECT * FROM users")
    users = c.fetchall()
    query = 'DELETE FROM users WHERE username="%s"' % username.strip()
    
    for user in users:
        if username == user[1]:
            c.execute(query)
            break

def remove_review():
    print("Not Implemented")

def remove_service():
    uid="Temporary"
    ticket_id = input("Enter the id of the ticket:")
    c.execute("SELECT * FROM jobs")
    query = 'DELETE FROM jobs WHERE user_id="%s"' % uid.strip()
    services = c.fetchall()
    for service in services:
        if ticket_id == service[0]:
            c.execute(query)
            break

def remove_contractor():
    print("Not Implemented")

def remove_payment_info():
    print("Not Implemented")

""" 
Update Information
 """
#Nothing here yet

""" 
Insertion functions
 """
# insert function users
def insert_users(uid, username, password, full_name, email):
    c.execute("INSERT INTO users VALUES(?,?,?,?,?)", (uid, username, password, full_name, email))

# insert function reviewers
def insert_review(uid, reviewer, date, contractor, rating, review):
    c.execute("INSERT INTO reviews VALUES(?,?,?,?,?,?)", (uid, reviewer, date, contractor, rating, review))

# insert function services
def insert_services(uid, poster, ticket_id, status, cost, h_bidder, date):
    c.execute("INSERT INTO jobs VALUES(?,?,?,?,?,?,?)", (uid, poster, ticket_id, status, cost, h_bidder, date))

# insert into paymentInfo
def insert_card_info(uid,holder, number, month, year, csv):
    c.execute("INSERT INTO paymentInfo VALEUS(?,?,?,?,?,?)", (uid, holder, number, month, year, csv))
    print("Not implemented")

#insert function contractors
def insert_contractors(cid, company_name, job, password, overall_stars):
    c.execute("INSERT INTO contractors VALUES(?,?,?,?,?)", (cid, company_name, job, password, overall_stars))

""" Print tables
 """
def print_users():
    c.execute("SELECT * from users")
    users = c.fetchall()
    for user in users:
        print("UID:", user[0], "\nUsername:", user[1], "\nPassword:", user[2], "\nName:", user[3], "\nEmail:", user[4], "\n===============================")
        
def print_reviews():
    c.execute("SELECT * from reviews")
    reviews = c.fetchall()
    for review in reviews:
        print("UID:", review[0], "\nReviewer:", review[1], "Date: ", review[2], "\nContractor:", review[3], "\nStar Rating:", review[4], "\nReview:", review[5], "\n===============================")

def print_services():
    c.execute("SELECT * FROM jobs")
    services= c.fetchall()
    for service in services:
        print("User ID:", service[0], "\nTicket Status:", service[1], "Current Price:", service[2], "Leading Bidder:", service[3], "\n===============================")

def print_payment_info():
    c.execute("SELECT * FROM paymentInfo")
    cards = c.fetchall()
    for card in cards:
        print("UID:", card[0],"\nCard Holder:", card[1], "Card Number:", card[2], "Month:", card[3], "Year:", card[4], "CSV:", card[5], "\n===============================")

def print_contractors():
    c.execute("SELECT * FROM contractors")
    contractors = c.fetchall()
    for contractor in contractors:
        print("Company ID:", contractor[1], "\nCompany Name:", contractor[0], "Service:", contractor[2], "Password:", contractor[3], "Overall Stars:", contractor[4], "\n===============================")

""" 
Menu functions
 """

def add_menu():
    add_menu_num=0
    while add_menu_num!="6":
        add_menu_num = make_choice("1: Add User\n2: Add Review\n3: Add Service(Don't choose. Needs to have stuff added in to work again.)\n4: Add Contractor\n5: Add Payment Information\n6 Return to Previous Menu\n")

        if add_menu_num=="1":
            add_user()
            break
        elif add_menu_num=="2":
            add_reviewers()
            break
        elif add_menu_num=="3":
            add_services()
            break
        elif add_menu_num=="4":
            add_contractors()
            break
        elif add_menu_num=="5":
            add_payment_info()
            break
        elif add_menu_num=="6":
            break
        else:
            print("Not a valid option/n")  

def removal_menu():
    removal_menu_num = make_choice("1: Remove User\n2: Remove Review\n3: Remove Service\n4: Remove Contractor\n5: Remove Payment Information\n6 Return to Previous Menu\n")
    while removal_menu_num!="6":
        if removal_menu_num=="1":
            remove_user()
            break
        elif removal_menu_num=="2":
            remove_review()
            break
        elif removal_menu_num=="3":
            remove_service()
            break
        elif removal_menu_num=="4":
            remove_contractor()
            break
        elif removal_menu_num=="5":
            remove_payment_info()
            break
        elif removal_menu_num=="6":
            break
        else:
            print("Not a valid option/n")

def print_menu():
    print_menu_num=make_choice("1: Show Users\n2: Show Reviews\n3: Show Services\n4: Show Contractors\n5: Show Payment Information\n6: Return to Previous Menu\n")
    while print_menu_num!="6":
        if print_menu_num=="1":
            print_users()
            break
        elif print_menu_num=="2":
            print_reviews()
            break
        elif print_menu_num=="3":
            print_services()
            break
        elif print_menu_num=="4":
            print_contractors()
            break
        elif print_menu_num=="5":
            print_payment_info()
            break
        elif print_menu_num=="6":
            break
        else:
            print("Not a valid input/n")
    print()

def make_choice(str):
    menu_num = input(str)
    return menu_num

#User ID function
def ID():
    y=""
    for x in range(10):
        x = random.randint(0,9)
        y += str(x)
    return y

def is_a_new_username(str):
    is_new_username = True
    c.execute("SELECT * from users")
    usernames = c.fetchall()
    for username in usernames:
        if username[1] == str:
            is_new_username = False
            break
    return is_new_username

# commit changes to database
def commit():
    conn.commit()

