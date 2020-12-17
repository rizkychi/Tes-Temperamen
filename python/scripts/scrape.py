#!/usr/bin/env python
import sys
import twint
import json

# Get argument value
val = sys.argv[1]

# Create empty variable
raw   = []
tweet = []

# Twint configuration
c = twint.Config()
c.Store_object    = True
c.Hide_output     = True
c.Custom['tweet'] = ['tweet']
c.Search          = f'from:{val} lang:id'

# Run Twint
twint.run.Search(c)
raw = twint.output.tweets_list

# Convert output to json object
for data in raw:
    tweet.append(data.tweet)

# Save object to json file
with open(f'temp/{val}.json', 'w') as f:
    json.dump(tweet, f)

# Print status
print('OK')