import {navigate} from "@reach/router";
import { IStaticContent } from './../typings/static.d';
import { IQuestion } from '../typings/question';
import { IAnswerResult } from "../typings/answer";

const baseUrl = 'https://ihh.local/wp-json/serviceadvisor/v1';

interface QuestionResponse {
  static: IStaticContent;
  questions: IQuestion[];
}

interface AnswerResponse {
  [key: number]: IAnswerResult;
}

export const fetchData = async (): Promise<QuestionResponse | void> => {
  const url = baseUrl + '/questions';

  return await request<QuestionResponse>(url);
}

export const postAnswers = async (answers: number[]): Promise<AnswerResponse | void> => {
  const url = baseUrl + '/answers';
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ answers })
  };

  return await request<AnswerResponse>(url, options);
}

export const sendResultAsEmail = async (mail: string, answers: number[]): Promise<boolean | void> => {
  const url = baseUrl + '/sendmail';
  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ mail, answers })
  }

  return await request<boolean>(url, options);
}

const request = async <T>(
  url: string,
  options: RequestInit = { headers: {'Content-Type': 'application/json'}}
): Promise<T | void> => {
  try {
    let apiUrl = url;
    if (process.env.REACT_APP_VERSION === 'service') {
      apiUrl += '?app=info'
    }
    const response = await fetch(apiUrl, options)
    return await response.json();
  } catch (err) {
    console.info(err);
  }
}

export const TIME_ELAPSED = 60000;

export const inactivityReset = () => {
  if (process.env.REACT_APP_VERSION === 'service') {
    let time: any;

    const resetTimer = () => {
      clearTimeout(time);
      time = setTimeout(logout, TIME_ELAPSED)
    }

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;

    const logout = async() =>  {
      await navigate('/');
    }
  }
}
