import { Router } from 'express';
import { indexPage, registerUser } from '../controller/userController.js';

const routerIndex = Router();

routerIndex.get('/', indexPage);
routerIndex.get('/register', registerUser);

export default routerIndex;