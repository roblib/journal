#!/usr/bin/env sh

if drush site-install journal -y --site-name="Test Journal"; then
    drush user-password admin $1
    drush ucrt "Sample Submitter" --password=$1
    drush user:role:add "journal_article_creator" "Sample Submitter"
    drush ucrt "Sample Reviewer" --password=$1
    drush user:role:add "journal_article_reviewer" "Sample Reviewer"
    drush en devel_generate
    drush devel-generate-content 1 --types=journal
    drush devel-generate-content 2 --types=issue
fi
