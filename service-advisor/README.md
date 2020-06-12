## Service Advisor App (IHHelsinki)

Internal implementation of the [public app](https://serviceadvisor.ihhelsinki.fi/). 

[Steve Davies](mailto:stephen.davies@digia.com)

### Demo
Latest demos to the app:
- Public version: http://ihhhelsinki.herokuapp.com/
- Service version: http://ihhhelsinki-service.herokuapp.com/

The app is supposed to support 4 languages (English, Russian, Finnish, Swedish), but at the moment only English is supported.

The backend API is not yet secured due to invalid certificate. So for the moment access to the demo is via `http` instead of `https`.

### Run
Make sure you have the dependencies installed. Add `.env` file based on `.env.example`. Then:

`npm run start`

### Build
`npm run build`
