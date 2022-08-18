#! /usr/bin/bash



cp ./core/data/projects.json ../Github-Portofolio/projects.json
cd ../Github-Portofolio/
git add *
git commit -m "add a project"
git push origin master