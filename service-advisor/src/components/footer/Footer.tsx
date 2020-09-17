import React from 'react';
import { processRawHTMLString, convertLineBreak, enableNewTabTargetForLink } from '../../helpers/render-helper';
import './Footer.scss';

type TProps = {
  logos: string[];
  contact: string;
};

const Footer = (props: TProps) => {
  const {logos, contact} = props;
  const contactContent = processRawHTMLString(contact, [convertLineBreak, enableNewTabTargetForLink]);

  return (
    <footer className="Footer__container">
      <div className="Footer__logosGroup">
        {logos.map(src => (
          <div className="Footer-imageContainer" key={src}>
            <img src={src} alt='International House Helsinki' />
          </div>
        ))}
      </div>
      <div
        className="Footer__contact"
        dangerouslySetInnerHTML={{__html: contactContent}}
      />
    </footer>
  );
};

export default Footer;
