--User tables

DROP TABLE IF EXISTS users;
CREATE TABLE users( 
    user_id TEXT NOT NULL, --use this values as input for the user_id in other user tables
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    full_name TEXT NOT NULL,
    email_address TEXT NOT NULL,
    UNIQUE(user_id),
    UNIQUE(username)
);

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews(
    user_id TEXT NOT NULL,
    reviewer TEXT NOT NULL,
    date TEXT NOT NULL, --date will might need to be split up depending on how the code for listing reviews is written.
    contractor_name TEXT NOT NULL, --Think we should change this to company name since they send the contractor out. Might simplify everything.
    star_rating REAL NOT NULL,
    comments TEXT NOT NULL
);

DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs(
    -- title and description of job should be added
    user_id TEXT NOT NULL,
    poster TEXT NOT NULL,
    job_title TEXT NOT NULL,
    job_description TEXT NOT NULL,
    ticket_id TEXT NOT NULL PRIMARY KEY,
    ticket_status TEXT NOT NULL, --three statuses? Bidding, In Progress, Done?
    current_cost REAL NOT NULL, --Do we actually need this if we have the companies just enter how low they are willing to go and they can only bid once?
    leading_bidder TEXT NOT NULL, --Bids like this are usually done companies bidding the lowest amount they are willing to be payed for the job. Person who put up job should then be able to choose the company based on bid and star rating
    date TEXT NOT NULL
);

DROP TABLE IF EXISTS paymentInfo;
CREATE TABLE paymentInfo(
    user_id TEXT NOT NULL,
    card_holder TEXT NOT NULL,
    card_number INTEGER NOT NULL,
    month INTEGER NOT NULL,
    year INTEGER NOT NULL,
    csv INTEGER NOT NULL
);

--Contractor tables

DROP TABLE IF EXISTS contractors;
CREATE TABLE contractors(
    company_name TEXT NOT NULL, 
    contractor_id TEXT NOT NULL, --Added this for ease of finding bank info
    type_of_service TEXT NOT NULL,
    password TEXT NOT NULL,
    overall_stars REAL NOT NULL, --Need method to calculate this. Add info about number of stars?
    PRIMARY KEY (company_name, contractor_id)
);

DROP TABLE IF EXISTS bank_info;
CREATE TABLE IF NOT EXISTS bank_info(
    contractor_id TEXT NOT NULL,
    routing_number INTEGER NOT NULL,
    account_number INTEGER NOT NULL PRIMARY KEY
);