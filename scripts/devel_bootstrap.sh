###!/usr/bin/env sh
drush @journal ucrt "Sample Submitter" --password=submitter
drush @journal urol journal_article_creator "Sample Submitter"

