# CORS - Cross Origin Ressource Sharing


## Exampe: React.JS Application
- Frontend served from URL1
- API served from URL2



#### NGinX

**Option 1**
- Use nginx as main traffic router
- Use proxy rewrite rules to redirect traffic [Example](https://stackoverflow.com/questions/43462367/how-to-overcome-the-cors-issue-in-reactjs)


#### Webpack Dev-Server
- [Use a proxy to redirect request to api](https://webpack.js.org/configuration/dev-server/#devserver-proxy)




