--- Admin 
create table if not exists admin(
  id serial primary key,
  username varchar(10) unique not null,
  encrypted_password text not null,
  salt text not null,
  created_at timestamptz default CURRENT_TIMESTAMP,
  updated_at timestamptz default CURRENT_TIMESTAMP,
  last_login timestamptz default CURRENT_TIMESTAMP
);
--- Donor
create table if not exists donors(
  id serial primary key,
  full_name varchar(400) not null,
  email varchar(200) unique not null,
  encrypted_password text not null,
  salt text not null,
  created_at timestamptz default CURRENT_TIMESTAMP,
  updated_at timestamptz default CURRENT_TIMESTAMP,
  last_login timestamptz default CURRENT_TIMESTAMP
);
--- Donation
create table if not exists donations(
  id serial primary key,
  cause varchar(400) not null,
  description text not null,
  target_amount DECIMAL(10,2) not null default 0.00,
  created_at timestamptz default CURRENT_TIMESTAMP,
  updated_at timestamptz default CURRENT_TIMESTAMP
);
--- Invoice
create table if not exists invoices(
  donation_id integer not null,
  donor_id integer not null,
  invoice_id varchar(200) not null unique,
  invoice_amount DECIMAL(10,2) not null default 0.00,
  invoice_status varchar(50) not null default 'NOT_SPECIFIED',
  invoice_date timestamptz not null,
  invoice_expiry timestamptz not null,
  invoice_to varchar(50) not null,
  invoice_data json,
  created_at timestamptz default CURRENT_TIMESTAMP,
  updated_at timestamptz default CURRENT_TIMESTAMP
);
--- Person to keep track of personal data
create table if not exists people(
  id serial primary key,
  full_name varchar(500) not null unique,
  background text,
  contact_info text
);
--- Beneficiary is a person who will be benefited from a given donation
create table if not exists beneficiaries(
  donation_id integer not null,
  person_id integer not null,
  amount DECIMAL(10,2) not null default 0.00,
  constraint unique_person_per_donation unique(donation_id,person_id)
);
