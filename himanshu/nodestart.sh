echo "Deployer Server"
#<<EOF
cd /u/apps/railyatri.agents_socket
git pull origin master && scp -r /u/apps/railyatri.agents_socket/* agent-server:/u/apps/railyatri.agents_socket/
#EOF
sleep 5
echo "Agent-server"
ssh agent-server 'bash -s' << EOF  
cd /u/apps/railyatri.agents_socket 
npm install
killall node
nohup node server.js &
EOF
