


	CRUD  -> C -> Create  				: INSERT
		 R -> Read		-> list/search  : SELECT
		 U -> Update				: SELECT + UPDATE
		 D -> Delete 				: SELECT + DELETE
		 
		 Auth			-> Login	: SELECT
		 			-> Register	: INSERT
		 			-> logout	: --
		 
		 CRUD+ AUTH = System



|root/  
├── 📂 Auth System (Identity & Security)  
│ ├── login.php # Validates credentials and starts user sessions  
│ ├── register.php # Handles new user creation with SHA-256 hashing  
│ ├── logout.php # Ends sessions and redirects to login  
│ └── profile.php # User-specific dashboard (filtered by Session ID)  
│  
├── 📂 CRUD Operations (Items Management)  
│ ├── index.php # Main landing page showing all items  
│ ├── create.php # Form and logic to add new records  
│ ├── show.php # Detailed view for a single specific item  
│ ├── update.php # Form to edit existing item data  
│ └── delete.php # Confirmation and removal of records  
│  
├── 📂 Search & Reporting  
│ ├── search.php # Basic search using SQL LIKE on item names  
│ ├── search\_by\_username.php # Advanced search using SQL JOIN  
│ └── list.php # Relational list showing items with owner names  
│

├── 📂 Auth System (Cookie-Based) │ ├── login\_with\_cookies.php # Uses setcookie() to save user data in the browser │ ├── logout\_with\_cookies.php # Deletes cookies by setting expiration to the past │ └── profile\_with\_cookies.php # Accesses user data via the $\_COOKIE array 

└── 📂 Database & Configuration  
├── db\_connect.php # Central PDO connection settings  
└── schema.sql # The SQL commands to build your tables
