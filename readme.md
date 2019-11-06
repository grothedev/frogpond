(This guide is incomplete)

# Frog Pond API:

    ### This API provides a way for developers to access and create croaks, files, and tags. It is a laravel application with a PostgreSQL database.  

# How to use the API:

    - error messages
    - Resources
        - Croak:
            - id (int) : primary key
            - created_at (string) : datetime croak was posted
            - updated_at (string) : datetime croak was last updated, presently always same as created
            - x (string) : longitude, encrypted hash string, based on private key of this laravel application
            - y (string) : latitude, encrypted hash string, based on private key of this laravel application
            - ip (string) : ip address of poster of croak, encrypted hash string, based on private key of this laravel application
            - type (int) : what type of croak, always 0 (unused) in FrogPond app
            - content (string) : variable unlimited length text
            - fade_rate (float) : 3 digit precision and 2 decimal digits, unused for FrogPond, was originally supposed to be used for a graphical application where posts would be on 2-dimensional canvas and rendered with decreasing opacity over time
            - score (int) : net result of upvotes (+1) and downvotes (-1)
            - reports (int) : how many times has been reported for illegallity or spam
            - p_id (int) : parent id
            - user_id (int) : user id, unused in FrogPond
        - Tag
            - id (int) : primary key
            - label (string) : the tag/concept/topic, unique, 
            - created_at (string) : datetime tag was created
            - refs (int) : number of times this tag has been referenced (how many croaks are associated with it)
        - File
            - id (int) : primary key
            - created_at (string) : datetime file was uploaded
            - filename (string) : name with extension
            - path (string) : relative to server root (really just "f/" prepended to filename)
            - filesize (int) : in bytes
        - Vote
            - id (int) : primary key
            - ip (string) : ip address of voter (encrypted)
            - v (boolean) : up (true) or down (false) vote
            - created_at (string) : datetime vote was casted
            - croak_id (int) : which croak 
        - Report
            - id (int) : primary key
            - ip (string) : ip address of voter (encrypted)
            - reason (string) : optional why the croak is unallowed
            - created_at (string) : datetime vote was casted
            - croak_id (int) : which croak
    - Getting Started
        The most common use case is that you want to see croaks in your area having to do with any of some set of concepts. For this, you would use 
    - Server Responses
        - when retreiving resources, the API will often return additional associated data in the JSON response. 
        - Croak
    

# REST endpoints:
    - GET api/croaks 