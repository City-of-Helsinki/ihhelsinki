const sanitizeHtml = require('sanitize-html');

const defaultOptions = {
  allowedTags: [ 'b', 'i', 'em', 'strong', 'a' ,'br', '&',';','/'],
  allowedAttributes: {
      'a': [ 'href' ]
  }
};

export const sanitize = (text: string) => {
  return sanitizeHtml(text, {...defaultOptions});
};

type RawHTMLProcessor = (html: string) => string;

export const convertLineBreak: RawHTMLProcessor = (htmlString: string = '') => {
  return htmlString.replace(/\n/g, '<br>');
}

export const enableNewTabTargetForLink: RawHTMLProcessor = (htmlString: string = '') => {
  return htmlString.replace(/<a/g, "<a class='external_link' target='_blank'");
}

export const processRawHTMLString = (htmlString: string = '', methods: RawHTMLProcessor[]): string => {
  let htmlContent = htmlString;
  methods.forEach(process => {
    htmlContent = process(htmlContent);
  });
  return htmlContent;
}

export const convertImageToDataURL = (url: string): Promise<string> => {
  return new Promise((resolve, reject) => {
    var img = new Image();
    img.setAttribute("crossOrigin", "anonymous");
    img.onload = () => {
      var canvas = document.createElement("canvas");
      canvas.width = img.width;
      canvas.height = img.height;
      var ctx: any = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0);
      var dataURL = canvas.toDataURL("image/png");
      resolve(dataURL);
    };
    img.onerror = error => {
      reject(error);
    };
    img.src = url;
  });
}

// attach classname for custom stylings for service version
export const attachServiceClassName = (className: string): string => {
  const isServiceVersion = process.env.REACT_APP_VERSION === 'service';
  const versionClassName = isServiceVersion ? ' App-service' : '';
  return className + versionClassName;
}
